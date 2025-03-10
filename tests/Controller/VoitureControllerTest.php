<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

final class VoitureControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?string $userToken = null;
    private ?string $adminToken = null;
    private ?int $userId = null;
    private ?int $voitureId = null;
    private ?string $userEmail = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->userEmail = 'test.user' . time() . '@example.com';

        // 🔹 Vérifier et créer l'admin
        $this->adminToken = $this->getToken('jean.dupont@example.com', 'password123');
        if (!$this->adminToken) {
            throw new \Exception("❌ Impossible d'obtenir un Token JWT pour l'admin jean.dupont@example.com.");
        }

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
                'idRole' => 2, // Utilisateur
                'idVille' => 1 // Paris
            ])
        );

        // 🔹 Vérification de la création
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Réponse création utilisateur : " . print_r($responseContent, true));

        $this->userId = $responseContent['id'] ?? null;
        $this->assertNotNull($this->userId, '❌ ID utilisateur non récupéré après inscription');

        // 🔹 Récupération du Token JWT utilisateur
        sleep(2); // 🔥 Pause pour éviter les problèmes d'écriture en base
        $this->userToken = $this->getToken($this->userEmail, 'password123');
        $this->assertNotNull($this->userToken, '❌ Échec de la récupération du token JWT utilisateur');
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

        if (!isset($response['token'])) {
            fwrite(STDERR, "❌ Échec de la récupération du Token JWT pour $email. Réponse API: " . print_r($response, true));
            return null;
        }

        return $response['token'];
    }

    public function testCreationVoiture(): void
    {
        $this->assertNotNull($this->userId, '❌ ID utilisateur non récupéré');
    
        // 🔹 Création d'une voiture
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
    
        sleep(2); // 🔥 Pause pour éviter les erreurs d'accès concurrents
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Réponse création voiture : " . print_r($responseContent, true));
    
        $this->assertResponseStatusCodeSame(201);
        $this->assertArrayHasKey('id', $responseContent, '❌ ID voiture manquant dans la réponse.');
    
        // ✅ Sauvegarde l'ID voiture récupéré
        $this->voitureId = $responseContent['id'];
        $this->assertNotNull($this->voitureId, '❌ ID voiture non récupéré après création');
    }

    public function testSuppressionVoiture(): void
    {
        $this->assertNotNull($this->voitureId, '❌ ID voiture non récupéré');

        // 🔍 Vérifier que la voiture existe bien avant suppression
        $this->client->request(
            'GET',
            "/api/voitures",
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->adminToken]
        );
        $responseBeforeDeletion = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Liste des voitures avant suppression : " . print_r($responseBeforeDeletion, true));

        // 🔹 Suppression de la voiture
        $this->client->request(
            'DELETE',
            "/api/voiture/{$this->voitureId}",
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->userToken]
        );

        $this->assertResponseStatusCodeSame(200);
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Réponse suppression voiture : " . print_r($responseContent, true));

        $this->assertEquals('Voiture supprimée avec succès', $responseContent['message']);

        // 🔍 Vérifier que la voiture n'existe plus
        $this->client->request(
            'GET',
            "/api/voitures",
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->adminToken]
        );
        $responseAfterDeletion = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Liste des voitures après suppression : " . print_r($responseAfterDeletion, true));

        // ✅ Vérifier que la voiture a bien été supprimée
        foreach ($responseAfterDeletion as $voiture) {
            $this->assertNotEquals($this->voitureId, $voiture['id'], '❌ La voiture n\'a pas été supprimée !');
        }
    }
}
