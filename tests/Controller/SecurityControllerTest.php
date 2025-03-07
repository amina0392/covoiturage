<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

final class SecurityControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }
    private function getToken(): string
    {
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'jean.dupont@example.com',  // 📌 Correction ici
                'password' => 'password123',
            ])
        );
    
        $response = json_decode($this->client->getResponse()->getContent(), true);
        return $response['token'] ?? '';
    }
    
    public function testLogin(): void
    {
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'jean.dupont@example.com',  // 📌 Correction ici
                'password' => 'password123',
            ])
        );
    
        $this->assertResponseIsSuccessful();
        
        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }
    
}
