<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Enum\RoleType;
use App\Entity\Utilisateur;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $roleAdmin = new Role();
        $roleAdmin->setNomRole(RoleType::ADMIN);  
        $manager->persist($roleAdmin);

        $roleUser = new Role();
        $roleUser->setNomRole(RoleType::UTILISATEUR);
        $manager->persist($roleUser);

        // CrÃ©e une ville
        $ville = new Ville();
        $ville->setCodePostale('75001');
        $ville->setNomCommune('Paris');
        $manager->persist($ville);

        $user = new Utilisateur();
        $user->setNom('Dupont');
        $user->setPrenom('Jean');
        $user->setEmail('jean.dupont@example.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $user->setRoleEntity($roleAdmin); 
        $user->setVille($ville);// Utilisation correcte
        $manager->persist($user);

        $manager->flush();
    }
}
