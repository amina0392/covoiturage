<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();

        // Effectuer une requête POST avec les bonnes données
        $client->request('POST', '/api/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'email' => 'jean.dupont@example.com', // 🟢 Remplace par un email valide dans ta base
            'password' => 'password123' // 🟢 Assure-toi que le mot de passe correspond
        ]));

        // Vérifier que la requête a réussi
        self::assertResponseIsSuccessful();

        // Vérifier que la réponse contient un token
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }
}
