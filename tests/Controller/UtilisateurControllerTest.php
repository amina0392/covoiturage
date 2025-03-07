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

        // 🔹 Suppression de l’utilisateur existant avant test
        $this->client->request('DELETE', "/api/utilisateur/email/{$this->userEmail}");

        // 🔹 Création d’un utilisateur de test
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
                'idRole' => 3,
                'idVille' => 2
            ])
        );

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        var_dump($responseContent); // DEBUG : Afficher la réponse pour voir si l'ID est bien là

        if (isset($responseContent['id'])) {
            $this->userId = $responseContent['id'];
        }

        $this->assertNotNull($this->userId, 'ID utilisateur non récupéré après inscription');

        // 🔹 Récupération du Token JWT après création
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

        if (!isset($response['token'])) {
            throw new \Exception('Impossible de récupérer le token JWT. Réponse reçue : ' . json_encode($response));
        }

        return $response['token'];
    }

    public function testModificationUtilisateur(): void
    {
        $this->assertNotNull($this->userId, 'ID utilisateur non récupéré après inscription');

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
        $this->assertNotNull($this->userId, 'ID utilisateur non récupéré après inscription');

        // 🔹 Suppression par ID
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
            // 🔹 Suppression de l’utilisateur après les tests
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
