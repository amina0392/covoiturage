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

        // Nettoyage des tables de test
        $this->entityManager->getConnection()->executeStatement("DROP TABLE IF EXISTS test_utilisateur, test_reservation, test_trajet");
        
        // Création des tables de test
        $this->entityManager->getConnection()->executeStatement("
            CREATE TABLE test_utilisateur AS SELECT * FROM utilisateur WHERE 1=0;
            CREATE TABLE test_reservation AS SELECT * FROM reservation WHERE 1=0;
            CREATE TABLE test_trajet AS SELECT * FROM trajet WHERE 1=0;
        ");
    }

    protected function tearDown(): void
    {
        if ($this->entityManager) {
            $this->entityManager->close();
            $this->entityManager = null;
        }
    }
}
