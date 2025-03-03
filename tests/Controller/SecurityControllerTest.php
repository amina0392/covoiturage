<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/login_check', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'username' => 'jean.dupont@example.com', 
            'password' => 'password123'       
        ]));

        self::assertResponseIsSuccessful();
        self::assertJson($client->getResponse()->getContent());
    }
}
