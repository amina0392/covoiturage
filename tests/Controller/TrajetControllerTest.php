<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

final class TrajetControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?string $userToken = null;
    private ?string $adminToken = null;
    private ?int $userId = null;
    private ?int $trajetId = null;
    private ?int $voitureId = null;
    private ?string $userEmail = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->userEmail = 'test.user' . time() . '@example.com';

        // 🔹 Vérification et Création de l'Admin si nécessaire
        $this->adminToken = $this->getToken('jean.dupont@example.com', 'password123');
        if (!$this->adminToken) {
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
            $this->adminToken = $this->getToken('jean.dupont@example.com', 'password123');
        }

        if (!$this->adminToken) {
            throw new \Exception("❌ Impossible d'obtenir un Token JWT pour jean.dupont@example.com.");
        }

        // 🔹 Création d’un Utilisateur avec Voiture
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
                'idRole' => 2, // Utilisateur
                'idVille' => 1
            ])
        );

        sleep(2);
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->userId = $responseContent['id'] ?? null;
        $this->assertNotNull($this->userId, '❌ ID utilisateur non récupéré après inscription');

        $this->userToken = $this->getToken($this->userEmail, 'password123');
        $this->assertNotNull($this->userToken, '❌ Échec de la récupération du token JWT utilisateur');

        // 🔹 Création de la Voiture
        $this->client->request(
            'POST',
            '/api/voiture',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer ' . $this->userToken],
            json_encode([
                'marque' => 'Toyota',
                'modele' => 'Yaris',
                'immatriculation' => 'AB-123-CD',
                'nb_places' => 4,
                'id_utilisateur' => $this->userId
            ])
        );

        sleep(2);
        $responseVoiture = json_decode($this->client->getResponse()->getContent(), true);
        $this->voitureId = $responseVoiture['id'] ?? null;
        $this->assertNotNull($this->voitureId, '❌ ID voiture non récupéré après création.');
    }

    private function getToken(string $email, string $password): ?string
    {
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $email,
                'password' => $password,
            ])
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);

        return $response['token'] ?? null;
    }

    public function testCreationTrajet(): void
    {
        $this->assertNotNull($this->voitureId, '❌ ID voiture non récupéré.');

        $this->client->request(
            'POST',
            '/api/trajet',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer ' . $this->userToken],
            json_encode([
                'id_utilisateur' => $this->userId,
                'id_ville_depart' => 1,
                'id_ville_arrivee' => 2,
                'date_heure' => '2025-03-10 14:00:00',
                'places_restantes' => 3,
                'detail_trajet' => 'Trajet sympa'
            ])
        );

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->trajetId = $responseContent['id'] ?? null;
        $this->assertNotNull($this->trajetId, '❌ ID trajet non récupéré après création');
    }

    public function testListeTrajets(): void
    {
        $this->client->request('GET', '/api/trajets', [], [], ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->adminToken]);
        $this->assertResponseIsSuccessful();
    }

    public function testRechercheTrajets(): void
    {
        $this->client->request(
            'GET',
            '/api/trajets/recherche?ville_depart=1&ville_arrivee=2',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->adminToken]
        );

        $this->assertResponseIsSuccessful();
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
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->adminToken]
            );
        }
    }
}
