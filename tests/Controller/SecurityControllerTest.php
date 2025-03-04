<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        
        // Simulez une requête POST pour le login
        $client->request('POST', '/api/login_check', [
            'email' => 'jean.dupont@example.com',
            'password' => 'password123',
        ]);

        // Vérifiez que la réponse est correcte
        $this->assertResponseIsSuccessful();

        // Vous pouvez aussi vérifier si le token est retourné
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }
}
