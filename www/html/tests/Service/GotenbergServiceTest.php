<?php

namespace App\Tests\Service;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GotenbergServiceTest extends KernelTestCase
{
    private GotenbergService $gotenbergService;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->gotenbergService = $container->get(GotenbergService::class);
    }

    public function testConvertUrlToPdf(): void
    {
        // Test de conversion d'une URL simple
        $url = 'https://www.google.com';

        $response = $this->gotenbergService->convertUrlToPdf($url);

        // Vérifier que la requête a réussi
        $this->assertEquals(200, $response->getStatusCode());

        // Vérifier que le contenu est bien un PDF
        $content = $response->getContent();
        $this->assertStringStartsWith('%PDF', $content);
    }

    public function testConvertUrlToPdfWithOptions(): void
    {
        // Test de conversion avec des options
        $url = 'https://www.example.com';
        $options = [
            'landscape' => true,
            'marginTop' => '1',
            'marginBottom' => '1',
        ];

        $response = $this->gotenbergService->convertUrlToPdf($url, $options);

        // Vérifier que la requête a réussi
        $this->assertEquals(200, $response->getStatusCode());

        // Vérifier que le contenu est bien un PDF
        $content = $response->getContent();
        $this->assertStringStartsWith('%PDF', $content);
    }

    public function testConvertUrlToPdfContent(): void
    {
        // Test de la méthode qui retourne directement le contenu
        $url = 'https://www.example.com';

        $content = $this->gotenbergService->convertUrlToPdfContent($url);

        // Vérifier que le contenu est bien un PDF
        $this->assertStringStartsWith('%PDF', $content);
        $this->assertNotEmpty($content);
    }
}
