<?php
namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DatabaseTestCase extends KernelTestCase
{
    protected ?EntityManager $entityManager = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();
        $conn = $this->entityManager->getConnection();

        // 🔹 Désactiver les clés étrangères avant de vider les tables
        $conn->executeStatement("SET FOREIGN_KEY_CHECKS=0;");
        $conn->executeStatement("TRUNCATE TABLE test_utilisateur;");
        $conn->executeStatement("TRUNCATE TABLE test_reservation;");
        $conn->executeStatement("TRUNCATE TABLE test_role;");
        $conn->executeStatement("TRUNCATE TABLE test_trajet;");
        $conn->executeStatement("TRUNCATE TABLE test_ville;");
        $conn->executeStatement("TRUNCATE TABLE test_voiture;");
        $conn->executeStatement("SET FOREIGN_KEY_CHECKS=1;");

        // 🔹 Réinsérer des données minimales pour garantir des tests fiables
        $conn->executeStatement("
            INSERT INTO test_role (id_role, nom_role) VALUES (1, 'utilisateur'), (2, 'admin');
            INSERT INTO test_ville (id_ville, code_postale, nom_commune) VALUES (1, '75001', 'Paris'), (2, '56000', 'Vannes');
            INSERT INTO test_utilisateur (id_utilisateur, id_role, id_ville, nom, prenom, email, mot_de_passe) 
            VALUES (999, 1, 1, 'Test', 'User', 'test.user@example.com', '\$2y\$13\$PVsGxbGnckoaiMOc3YHenOLVNsTYzSN/2D5xfbw4xWg2iTrnNy8De');
            INSERT INTO test_voiture (id_voiture, marque, modele, immatriculation, nb_places, id_utilisateur)
            VALUES (1, 'Peugeot', '208', 'CD-456-EF', 4, 999);
        ");
    }

    protected function tearDown(): void
    {
        if ($this->entityManager) {
            $this->entityManager->close();
            $this->entityManager = null;
        }
    }

    protected function resetDatabase(): void
{
    $conn = $this->entityManager->getConnection();
    
    // Désactiver les contraintes pour éviter les erreurs de clé étrangère
    $conn->executeStatement("SET FOREIGN_KEY_CHECKS=0;");
    $conn->executeStatement("TRUNCATE TABLE test_utilisateur;");
    $conn->executeStatement("TRUNCATE TABLE test_reservation;");
    $conn->executeStatement("TRUNCATE TABLE test_role;");
    $conn->executeStatement("TRUNCATE TABLE test_trajet;");
    $conn->executeStatement("TRUNCATE TABLE test_ville;");
    $conn->executeStatement("TRUNCATE TABLE test_voiture;");
    $conn->executeStatement("SET FOREIGN_KEY_CHECKS=1;");
    
    // Réinsérer les données minimales pour les tests
    $conn->executeStatement("
        INSERT INTO test_role (id_role, nom_role) VALUES (1, 'utilisateur'), (2, 'admin');
        INSERT INTO test_ville (id_ville, code_postale, nom_commune) VALUES (1, '75001', 'Paris'), (2, '56000', 'Vannes');
        INSERT INTO test_utilisateur (id_utilisateur, id_role, id_ville, nom, prenom, email, mot_de_passe) 
        VALUES (999, 1, 1, 'Test', 'User', 'test.user@example.com', '\$2y\$13\$PVsGxbGnckoaiMOc3YHenOLVNsTYzSN/2D5xfbw4xWg2iTrnNy8De');
        INSERT INTO test_voiture (id_voiture, marque, modele, immatriculation, nb_places, id_utilisateur)
        VALUES (1, 'Peugeot', '208', 'CD-456-EF', 4, 999);
    ");
}

}
