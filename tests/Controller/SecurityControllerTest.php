<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        // Envoie une requête POST avec des données de login
        $client->request('POST', '/api/login_check', [
            'username' => 'jean.dupont@example.com',
            'password' => 'password123',
        ]);

        // Vérifie si la réponse est réussie
        $this->assertResponseIsSuccessful();
    }
}
