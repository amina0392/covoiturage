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
        $this->userEmail = 'test.user' . time() . '@example.com';
    
        // 🔹 Création d’un utilisateur classique
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
                'idRole' => 2, // Rôle utilisateur
                'idVille' => 1 // Ville Paris
            ])
        );
    
        // 🔹 Vérification de la réponse
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Réponse création utilisateur : " . print_r($responseContent, true));
    
        $this->userId = $responseContent['id'] ?? null;
        $this->assertNotNull($this->userId, '❌ ID utilisateur non récupéré après inscription');
    
        // 🔹 Récupération du Token JWT
        $this->token = $this->getToken($this->userEmail);
        $this->assertNotNull($this->token, '❌ Échec de la récupération du token JWT');
    
        // 🔹 Création d’un admin pour tester la liste des utilisateurs
        $adminEmail = 'admin.test' . time() . '@example.com';
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
                'idRole' => 1, // Admin
                'idVille' => 1
            ])
        );
    
        // 🔹 Vérification et récupération de l'ID admin
        $adminResponse = json_decode($this->client->getResponse()->getContent(), true);
        fwrite(STDERR, "📌 Réponse création admin : " . print_r($adminResponse, true));
    
        $this->adminId = $adminResponse['id'] ?? null;
        $this->assertNotNull($this->adminId, '❌ ID admin non récupéré après inscription');
    
        // 🔹 Attendre que l'admin soit bien enregistré en base (SQLite peut avoir un délai)
        sleep(1); // 🔥 Ajoute une pause pour assurer l'écriture en base
    
        // 🔹 Récupération du Token JWT pour l'admin
        $this->adminToken = $this->getToken($adminEmail);
        if (!$this->adminToken) {
            throw new \Exception("❌ Impossible d'obtenir un Token JWT pour un admin temporaire.");
        }
    
        fwrite(STDERR, "✅ Token JWT Admin récupéré : " . $this->adminToken);
    }
    

    /**
 * 🔍 Vérification des rôles et villes avant les tests
 */
private function debugDatabase(): void
{
    echo "\n🔍 Vérification des rôles et villes dans la base de données:\n";

    // 🔹 Récupération du Token JWT pour un admin temporaire
    $adminEmail = 'admin.test' . time() . '@example.com';
    $this->client->request(
        'POST',
        '/api/utilisateur',
        [],
        [],
        ['CONTENT_TYPE' => 'application/json'],
        json_encode([
            'nom' => 'AdminTest',
            'prenom' => 'Test',
            'email' => $adminEmail,
            'motDePasse' => 'password123',
            'idRole' => 1, // 📌 ID Admin
            'idVille' => 1
        ])
    );

    $adminResponse = json_decode($this->client->getResponse()->getContent(), true);
    $adminToken = $this->getToken($adminEmail);

    if (!$adminToken) {
        throw new \Exception("❌ Impossible d'obtenir un Token JWT pour un admin temporaire.");
    }

    // 🔹 Requête pour récupérer les rôles
    $this->client->request(
        'GET',
        '/api/roles',
        [],
        [],
        ['HTTP_AUTHORIZATION' => 'Bearer ' . $adminToken]
    );
    $rolesResponse = $this->client->getResponse()->getContent();
    echo "📌 Rôles: " . $rolesResponse . "\n";

    // 🔹 Requête pour récupérer les villes
    $this->client->request(
        'GET',
        '/api/villes',
        [],
        [],
        ['HTTP_AUTHORIZATION' => 'Bearer ' . $adminToken]
    );
    $villesResponse = $this->client->getResponse()->getContent();
    echo "📌 Villes: " . $villesResponse . "\n";
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
