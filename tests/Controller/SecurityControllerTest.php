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
            'password' => 'password123', // Assurez-vous que le mot de passe est correct
        ]);

        // Vérifiez si la réponse est un succès
        $this->assertResponseIsSuccessful();

        // Vérifiez si un token est retourné
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }
}
