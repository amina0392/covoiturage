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
            'email' => 'test.user@example.com',
            'password' => 'password123',
        ])
    );

    $response = json_decode($this->client->getResponse()->getContent(), true);
    return $response['token'] ?? '';
}

public function testInscription(): void
{
    $token = $this->getToken();
    
    $this->client->request(
        'POST',
        '/api/utilisateur',
        [],
        [],
        [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token
        ],
        json_encode([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont@example.com',
            'motDePasse' => 'password123',
            'idRole' => 1,
            'idVille' => 1
        ])
    );

    $this->assertResponseStatusCodeSame(201);
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
                'email' => 'test.user@example.com',
                'password' => 'password123',
            ])
        );

        $this->assertResponseIsSuccessful();
        
        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }

    public function testListeUtilisateurs(): void
    {
        $this->client->request('GET', '/api/utilisateurs');

        $this->assertResponseIsSuccessful();
        
        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);
    }
}
