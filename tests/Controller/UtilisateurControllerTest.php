<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

final class UtilisateurControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?string $token = null;
    private ?int $userId = null;
    private ?string $adminToken = null;
    private ?int $adminId = null;
    private ?string $userEmail = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        // 🔹 Vérification des rôles et villes avant de créer un utilisateur
        $this->debugDatabase();

        $this->userEmail = 'test.user' . time() . '@example.com';

        // 🔹 Création d’un utilisateur standard (ROLE_UTILISATEUR)
        $this->client->request(
            'POST',
            '/api/utilisateur',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'nom' => 'Test',
                'prenom' => 'User',
                'email' => $this->userEmail,
                'motDePasse' => 'password123',
                'idRole' => 2, // 📌 Rôle utilisateur
                'idVille' => 1  // 📌 Ville Paris
            ])
        );

        // 🔹 Vérification et affichage de la réponse
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Réponse création utilisateur : " . print_r($responseContent, true));

        $this->userId = $responseContent['id'] ?? null;
        $this->assertNotNull($this->userId, '❌ ID utilisateur non récupéré après inscription');

        // 🔹 Récupération du Token JWT pour l'utilisateur
        $this->token = $this->getToken($this->userEmail);
        $this->assertNotNull($this->token, '❌ Échec de la récupération du token JWT');

        // 🔹 Création d’un admin pour la liste des utilisateurs
        $adminEmail = 'admin.user' . time() . '@example.com';
        $this->client->request(
            'POST',
            '/api/utilisateur',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'nom' => 'Admin',
                'prenom' => 'User',
                'email' => $adminEmail,
                'motDePasse' => 'password123',
                'idRole' => 1, // 📌 Rôle Admin
                'idVille' => 1
            ])
        );

        // 🔹 Vérification et affichage de la réponse Admin
        $adminResponse = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Réponse création admin : " . print_r($adminResponse, true));

        $this->adminId = $adminResponse['id'] ?? null;
        $this->assertNotNull($this->adminId, '❌ ID admin non récupéré après inscription');

        // 🔹 Récupération du Token JWT pour l'admin
        $this->adminToken = $this->getToken($adminEmail);
        $this->assertNotNull($this->adminToken, '❌ Échec de la récupération du token admin');
    }

    /**
     * 🔍 Vérification des rôles et villes avant les tests
     */
    private function debugDatabase(): void
    {
        echo "\n🔍 Vérification des rôles et villes dans la base de données:\n";

        $this->client->request('GET', '/api/roles');
        $rolesResponse = $this->client->getResponse()->getContent();
        echo "📌 Rôles: " . $rolesResponse . "\n";

        $this->client->request('GET', '/api/villes');
        $villesResponse = $this->client->getResponse()->getContent();
        echo "📌 Villes: " . $villesResponse . "\n";
    }

    /**
     * 🔐 Récupération du Token JWT pour un utilisateur donné
     */
    private function getToken(string $email): ?string
    {
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $email,
                'password' => 'password123',
            ])
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);
        return $response['token'] ?? null;
    }


    public function testModificationUtilisateur(): void
    {
        $this->assertNotNull($this->userId, '❌ ID utilisateur non récupéré');

        $this->client->request(
            'PUT',
            "/api/utilisateur/{$this->userId}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token],
            json_encode([
                'nom' => 'UserModif',
                'prenom' => 'TestModif',
                'email' => 'modif' . time() . '@example.com'
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function testSuppressionUtilisateur(): void
    {
        $this->assertNotNull($this->userId, '❌ ID utilisateur non récupéré');

        $this->client->request(
            "DELETE",
            "/api/utilisateur/{$this->userId}",
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
        );

        $this->assertResponseStatusCodeSame(200);
    }

    public function testListeUtilisateurs(): void
    {
        $this->client->request(
            'GET',
            '/api/utilisateurs',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->adminToken]
        );

        $this->assertResponseIsSuccessful();
        $response = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, print_r($response, true)); // LOG pour voir la réponse de liste utilisateur

        $this->assertIsArray($response);
        $this->assertGreaterThanOrEqual(1, count($response), '❌ La liste des utilisateurs ne doit pas être vide.');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // 🔹 Suppression de l'utilisateur
        if ($this->userId) {
            $this->client->request(
                "DELETE",
                "/api/utilisateur/{$this->userId}",
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
        }

        // 🔹 Suppression de l'admin
        if ($this->adminId) {
            $this->client->request(
                "DELETE",
                "/api/utilisateur/{$this->adminId}",
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->adminToken]
            );
        }
    }
}
