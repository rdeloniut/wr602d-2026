<?php

namespace App\Controller;

use App\Form\HtmlConversionType;
use App\Form\MarkdownConversionType;
use App\Form\MergePdfType;
use App\Form\OfficeConversionType;
use App\Form\PdfConversionType;
use App\Form\ScreenshotType;
use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/convert')]
class PdfController extends AbstractController
{
    public function __construct(private GotenbergService $gotenbergService) {}

    // ── URL vers PDF ──

    #[Route('/url', name: 'app_convert_url')]
    public function url(Request $request): Response
    {
        $form = $this->createForm(PdfConversionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $pdfContent = $this->gotenbergService->convertUrlToPdfContent($data['url']);

                return new Response($pdfContent, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="url_' . time() . '.pdf"',
                ]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la génération du PDF : ' . $e->getMessage());
            }
        }

        return $this->render('pdf/url.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // ── HTML vers PDF ──

    #[Route('/html', name: 'app_convert_html')]
    public function html(Request $request): Response
    {
        $form = $this->createForm(HtmlConversionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            try {
                $pdfContent = $this->gotenbergService->convertHtmlToPdfContent($file);

                return new Response($pdfContent, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="html_' . time() . '.pdf"',
                ]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la conversion : ' . $e->getMessage());
            }
        }

        return $this->render('pdf/html.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // ── Markdown vers PDF ──

    #[Route('/markdown', name: 'app_convert_markdown')]
    public function markdown(Request $request): Response
    {
        $form = $this->createForm(MarkdownConversionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            try {
                $pdfContent = $this->gotenbergService->convertMarkdownToPdfContent($file);

                return new Response($pdfContent, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="markdown_' . time() . '.pdf"',
                ]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la conversion : ' . $e->getMessage());
            }
        }

        return $this->render('pdf/markdown.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // ── Office vers PDF ──

    #[Route('/office', name: 'app_convert_office')]
    public function office(Request $request): Response
    {
        $form = $this->createForm(OfficeConversionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            try {
                $pdfContent = $this->gotenbergService->convertOfficeToPdfContent($file);

                return new Response($pdfContent, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="office_' . time() . '.pdf"',
                ]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la conversion : ' . $e->getMessage());
            }
        }

        return $this->render('pdf/office.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // ── Fusion de PDF ──

    #[Route('/merge', name: 'app_convert_merge')]
    public function merge(Request $request): Response
    {
        $form = $this->createForm(MergePdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('files')->getData();

            try {
                $pdfContent = $this->gotenbergService->mergePdfsContent($files);

                return new Response($pdfContent, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="merged_' . time() . '.pdf"',
                ]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la fusion : ' . $e->getMessage());
            }
        }

        return $this->render('pdf/merge.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // ── Capture d'écran ──

    #[Route('/screenshot', name: 'app_convert_screenshot')]
    public function screenshot(Request $request): Response
    {
        $form = $this->createForm(ScreenshotType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $imageContent = $this->gotenbergService->screenshotUrlContent($data['url']);

                return new Response($imageContent, 200, [
                    'Content-Type' => 'image/png',
                    'Content-Disposition' => 'attachment; filename="screenshot_' . time() . '.png"',
                ]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la capture : ' . $e->getMessage());
            }
        }

        return $this->render('pdf/screenshot.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
