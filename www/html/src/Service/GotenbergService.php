<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GotenbergService
{
    private HttpClientInterface $httpClient;
    private string $gotenbergUrl;

    public function __construct(HttpClientInterface $httpClient, string $gotenbergUrl)
    {
        $this->httpClient = $httpClient;
        $this->gotenbergUrl = $gotenbergUrl;
    }

    // ── URL vers PDF ──

    public function convertUrlToPdf(string $url, array $options = []): ResponseInterface
    {
        $formData = array_merge(['url' => $url], $options);

        return $this->httpClient->request('POST', $this->gotenbergUrl . '/forms/chromium/convert/url', [
            'headers' => [
                'Content-type' => 'multipart/form-data'
            ],
            'body' => $formData,
        ]);
    }

    public function convertUrlToPdfContent(string $url, array $options = []): string
    {
        $response = $this->convertUrlToPdf($url, $options);
        return $response->getContent();
    }

    // ── HTML vers PDF ──

    public function convertHtmlToPdfContent(UploadedFile $file): string
    {
        $formData = new FormDataPart([
            'files' => DataPart::fromPath($file->getPathname(), 'index.html', 'text/html'),
        ]);

        $response = $this->httpClient->request('POST', $this->gotenbergUrl . '/forms/chromium/convert/html', [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable(),
        ]);

        return $response->getContent();
    }

    // ── Markdown vers PDF ──

    public function convertMarkdownToPdfContent(UploadedFile $file): string
    {
        $filename = $file->getClientOriginalName();
        $wrapperHtml = '<!DOCTYPE html><html><head><style>body{font-family:sans-serif;padding:2rem;max-width:800px;margin:0 auto;line-height:1.6}</style></head><body>{{ toHTML "' . $filename . '" }}</body></html>';

        $formData = new FormDataPart([
            'files' => new DataPart($wrapperHtml, 'index.html', 'text/html'),
            'markdown' => DataPart::fromPath($file->getPathname(), $filename, 'text/markdown'),
        ]);

        $response = $this->httpClient->request('POST', $this->gotenbergUrl . '/forms/chromium/convert/markdown', [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable(),
        ]);

        return $response->getContent();
    }

    // ── Office vers PDF (LibreOffice) ──

    public function convertOfficeToPdfContent(UploadedFile $file): string
    {
        $formData = new FormDataPart([
            'files' => DataPart::fromPath(
                $file->getPathname(),
                $file->getClientOriginalName(),
                $file->getMimeType() ?? 'application/octet-stream'
            ),
        ]);

        $response = $this->httpClient->request('POST', $this->gotenbergUrl . '/forms/libreoffice/convert', [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable(),
        ]);

        return $response->getContent();
    }

    // ── Fusion de PDF ──

    public function mergePdfsContent(array $files): string
    {
        $parts = [];
        foreach ($files as $i => $file) {
            $parts['pdf_' . $i] = DataPart::fromPath(
                $file->getPathname(),
                sprintf('%03d_%s', $i, $file->getClientOriginalName()),
                'application/pdf'
            );
        }

        $formData = new FormDataPart($parts);

        $response = $this->httpClient->request('POST', $this->gotenbergUrl . '/forms/pdfengines/merge', [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable(),
        ]);

        return $response->getContent();
    }

    // ── Capture d'écran (Screenshot) ──

    public function screenshotUrlContent(string $url): string
    {
        $response = $this->httpClient->request('POST', $this->gotenbergUrl . '/forms/chromium/screenshot/url', [
            'headers' => [
                'Content-type' => 'multipart/form-data'
            ],
            'body' => ['url' => $url],
        ]);

        return $response->getContent();
    }
}
