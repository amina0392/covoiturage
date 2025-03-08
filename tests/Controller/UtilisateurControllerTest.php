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

    /**
     * 🔄 Réinitialise la base avant chaque test
     */
    private function resetDatabase(): void
    {
        $databasePath = self::$kernel->getProjectDir() . '/var/test.db';
        if (file_exists($databasePath)) {
            unlink($databasePath);
        }
        touch($databasePath);

        // Rechargement des migrations et fixtures
        shell_exec('php bin/console doctrine:migrations:migrate --no-interaction --env=test');
        shell_exec('php bin/console doctrine:fixtures:load --no-interaction --env=test');

        fwrite(STDERR, "✅ Base de données réinitialisée avec succès.\n");
    }

    /**
     * 🔍 Vérifie l'existence de l'admin et le crée si besoin
     */
    private function ensureAdminExists(): void
    {
        $this->adminToken = $this->getToken('jean.dupont@example.com');

        if (!$this->adminToken) {
            fwrite(STDERR, "❌ L'admin jean.dupont@example.com n'existe pas, création en cours...\n");

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
                    'idRole' => 1, // Admin
                    'idVille' => 1
                ])
            );

            sleep(2);
            $this->adminToken = $this->getToken('jean.dupont@example.com');

            if (!$this->adminToken) {
                throw new \Exception("❌ Impossible d'obtenir un Token JWT pour l'admin jean.dupont@example.com.");
            }
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        // 🔥 Réinitialisation de la base avant chaque test
        $this->resetDatabase();

        // 🔐 Vérification et récupération de l'admin
        $this->ensureAdminExists();

        $this->userEmail = 'test.user' . time() . '@example.com';

        // 🔹 Création d’un utilisateur classique
        $this->client->request(
            'POST',
            '/api/utilisateur',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer ' . $this->adminToken],
            json_encode([
                'nom' => 'Test',
                'prenom' => 'User',
                'email' => $this->userEmail,
                'motDePasse' => 'password123',
                'idRole' => 2, // Rôle utilisateur
                'idVille' => 1 // Ville Paris
            ])
        );

        // 🔹 Vérification de la réponse
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Réponse création utilisateur : " . print_r($responseContent, true));

        $this->userId = $responseContent['id'] ?? null;
        $this->assertNotNull($this->userId, '❌ ID utilisateur non récupéré après inscription');

        // 🔹 Récupération du Token JWT utilisateur
        sleep(2);
        $this->token = $this->getToken($this->userEmail);
        $this->assertNotNull($this->token, '❌ Échec de la récupération du token JWT utilisateur');
    }

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

        if (!isset($response['token'])) {
            fwrite(STDERR, "❌ Échec de la récupération du Token JWT pour $email. Réponse API: " . print_r($response, true));
            return null;
        }

        return $response['token'];
    }

    public function testConnexionUtilisateur(): void
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
        fwrite(STDERR, "📌 Réponse connexion utilisateur : " . print_r($response, true));

        $this->assertArrayHasKey('token', $response, '❌ Le token JWT n’a pas été retourné.');
        $this->assertNotEmpty($response['token'], '❌ Le token JWT est vide.');
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
        fwrite(STDERR, print_r($response, true));

        $this->assertIsArray($response);
        $this->assertGreaterThanOrEqual(1, count($response), '❌ La liste des utilisateurs ne doit pas être vide.');
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
