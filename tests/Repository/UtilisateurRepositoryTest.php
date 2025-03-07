<?php
namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;

class UtilisateurRepositoryTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testFindUtilisateurByEmail()
    {
        $repo = $this->entityManager->getRepository(Utilisateur::class);
        $utilisateur = $repo->findOneBy(['email' => 'test.user@example.com']);

        $this->assertNotNull($utilisateur);
        $this->assertEquals('Test', $utilisateur->getNom());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
