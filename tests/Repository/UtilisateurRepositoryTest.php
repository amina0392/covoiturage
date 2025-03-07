<?php
namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Entity\Role;
use App\Entity\Ville;
use App\Enum\RoleType; // 📌 Import de l'Enum
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurRepositoryTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager = null;
    private ?Utilisateur $testUser = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);

        // 🔹 Vérifier et créer un rôle avec `RoleType`
        $roleRepo = $this->entityManager->getRepository(Role::class);
        $role = $roleRepo->findOneBy(['nomRole' => RoleType::UTILISATEUR->value]); 
        if (!$role) {
            $role = new Role();
            $role->setNomRole(RoleType::UTILISATEUR); 
            $this->entityManager->persist($role);
        }

        // 🔹 Vérifier et créer une ville
        $villeRepo = $this->entityManager->getRepository(Ville::class);
        $ville = $villeRepo->findOneBy(['nomCommune' => 'Paris']);
        if (!$ville) {
            $ville = new Ville();
            $ville->setCodePostale('75001');
            $ville->setNomCommune('Paris');
            $this->entityManager->persist($ville);
        }

        // 🔹 Vérifier si l'utilisateur existe déjà
        $repo = $this->entityManager->getRepository(Utilisateur::class);
        $this->testUser = $repo->findOneBy(['email' => 'jean.dupont@example.com']);

        if (!$this->testUser) {
            // 🔹 Création d'un utilisateur test
            $this->testUser = new Utilisateur();
            $this->testUser->setNom('Dupont');
            $this->testUser->setPrenom('Jean');
            $this->testUser->setEmail('jean.dupont@example.com');
            $this->testUser->setPassword($passwordHasher->hashPassword($this->testUser, 'password123'));
            $this->testUser->setRoleEntity($role);
            $this->testUser->setVille($ville);

            $this->entityManager->persist($this->testUser);
            $this->entityManager->flush();
        }
    }

    public function testFindUtilisateurByEmail(): void
    {
        $repo = $this->entityManager->getRepository(Utilisateur::class);
        $utilisateur = $repo->findOneBy(['email' => 'jean.dupont@example.com']); 

        $this->assertNotNull($utilisateur, 'L\'utilisateur doit exister.');
        $this->assertEquals('Dupont', $utilisateur->getNom());
    }

    public function testFindAllUtilisateurs(): void
    {
        $repo = $this->entityManager->getRepository(Utilisateur::class);
        $utilisateurs = $repo->findAll();

        $this->assertNotEmpty($utilisateurs, 'La liste des utilisateurs ne doit pas être vide.');
        $this->assertGreaterThanOrEqual(1, count($utilisateurs));
    }

    public function testFindByRole(): void
    {
        $repo = $this->entityManager->getRepository(Utilisateur::class);
        $utilisateurs = $repo->findBy(['role' => $this->testUser->getRoleEntity()]);

        $this->assertNotEmpty($utilisateurs, 'Il doit y avoir au moins un utilisateur avec ce rôle.');
    }

    public function testRemoveUtilisateur(): void
    {
        $repo = $this->entityManager->getRepository(Utilisateur::class);
        $userToRemove = $repo->findOneBy(['email' => 'jean.dupont@example.com']);

        $this->assertNotNull($userToRemove, 'Utilisateur à supprimer introuvable.');

        $this->entityManager->remove($userToRemove);
        $this->entityManager->flush();

        $deletedUser = $repo->findOneBy(['email' => 'jean.dupont@example.com']);
        $this->assertNull($deletedUser, 'L\'utilisateur n\'a pas été supprimé.');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
