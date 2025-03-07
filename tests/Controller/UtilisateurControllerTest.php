<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

final class UtilisateurControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?string $token = null;
    private ?int $userId = null;
    private ?string $userEmail = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->userEmail = 'test.user' . time() . '@example.com';

        // 🔹 Suppression de l’utilisateur s'il existe déjà
        $this->client->request('DELETE', "/api/utilisateur/email/{$this->userEmail}");

        // 🔹 Création d’un utilisateur
        $this->client->request(
            'POST',
            '/api/utilisateur',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'nom' => 'Admin',
                'prenom' => 'User',
                'email' => $this->userEmail,
                'motDePasse' => 'password123',
                'idRole' => 4,
                'idVille' => 2
            ])
        );

        // 🔹 Vérification de la création
        $statusCode = $this->client->getResponse()->getStatusCode();
        $this->assertResponseStatusCodeSame(201, "Erreur création utilisateur : " . $this->client->getResponse()->getContent());

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->userId = $responseContent['id'] ?? null;
        $this->assertNotNull($this->userId, 'ID utilisateur non récupéré après inscription');

        // 🔹 Récupération du Token JWT
        $this->token = $this->getToken();
        $this->assertNotNull($this->token, 'Échec de la récupération du token JWT');
    }

    private function getToken(): ?string
    {
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $this->userEmail,
                'password' => 'password123',
            ])
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);
        return $response['token'] ?? null;
    }

    private function getRoleId(string $roleName): int
    {
        $roles = [
            'admin' => 3,
            'utilisateur' => 4,
        ];

        if (!isset($roles[$roleName])) {
            throw new \Exception("Rôle non trouvé : " . $roleName);
        }

        return $roles[$roleName];
    }

    private function getVilleId(string $villeName): int
    {
        $villes = [
            'Paris' => 2,
        ];

        if (!isset($villes[$villeName])) {
            throw new \Exception("Ville non trouvée : " . $villeName);
        }

        return $villes[$villeName];
    }

    public function testModificationUtilisateur(): void
    {
        $this->assertNotNull($this->userId, 'ID utilisateur non récupéré');

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
        $this->assertNotNull($this->userId, 'ID utilisateur non récupéré');

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
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
        );

        $this->assertResponseIsSuccessful();
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertIsArray($response);
        $this->assertGreaterThanOrEqual(1, count($response), 'La liste des utilisateurs ne doit pas être vide.');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        if ($this->userId) {
            $this->client->request(
                "DELETE",
                "/api/utilisateur/{$this->userId}",
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
        }
    }
}
