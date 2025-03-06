<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SecurityControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        // Inscription d'un utilisateur avant de tester le login
        $this->client->request(
            'POST',
            '/api/utilisateur',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'email' => 'jean.dupont@example.com',
                'motDePasse' => 'password123',
                'idRole' => 1,
                'idVille' => 1
            ])
        );

        // Vérifie si l'utilisateur a bien été créé
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
                'email' => 'jean.dupont@example.com',
                'password' => 'password123',
            ])
        );

        // Vérifie si la réponse est un succès (200 OK)
        $this->assertResponseIsSuccessful();

        // Vérifie si un token est retourné
        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }

    public function testListeUtilisateurs(): void
{
    $this->client->request('GET', '/api/utilisateurs');

    // Vérifie si la réponse est 200 OK
    $this->assertResponseIsSuccessful();

    // Vérifie que la réponse contient une liste d’utilisateurs
    $response = $this->client->getResponse();
    $data = json_decode($response->getContent(), true);
    $this->assertIsArray($data);
}

}
