<?php
namespace App\Tests\Entity;

use App\Entity\Utilisateur;
use App\Entity\Role;
use App\Entity\Ville;
use App\Entity\Voiture;
use PHPUnit\Framework\TestCase;
use App\Enum\RoleType;


class UtilisateurTest extends TestCase
{
    public function testGetSetNom(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setNom('Dupont');

        $this->assertEquals('Dupont', $utilisateur->getNom());
    }

    public function testGetSetPrenom(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setPrenom('Jean');

        $this->assertEquals('Jean', $utilisateur->getPrenom());
    }

    public function testGetSetEmail(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail('jean.dupont@example.com');

        $this->assertEquals('jean.dupont@example.com', $utilisateur->getEmail());
    }

    public function testGetSetPassword(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setPassword('password123');

        $this->assertEquals('password123', $utilisateur->getPassword());
    }

    public function testGetSetRole(): void
    {
        $utilisateur = new Utilisateur();
        $role = new Role();
        
        // Utilisation correcte de l'énumération
        $role->setNomRole(RoleType::ADMIN);
    
        $utilisateur->setRoleEntity($role);
    
        $this->assertSame($role, $utilisateur->getRoleEntity());
        $this->assertEquals(['ROLE_ADMIN'], $utilisateur->getRoles());
    }
    

    public function testGetSetVille(): void
    {
        $utilisateur = new Utilisateur();
        $ville = new Ville();
        $ville->setNomCommune('Paris');

        $utilisateur->setVille($ville);

        $this->assertSame($ville, $utilisateur->getVille());
    }

    public function testGetSetVoiture(): void
    {
        $utilisateur = new Utilisateur();
        $voiture = new Voiture();
        $voiture->setMarque('Peugeot');
        $voiture->setModele('208');
        $voiture->setImmatriculation('AA-123-BB');
        $voiture->setNbPlaces(5);

        $utilisateur->setVoiture($voiture);

        $this->assertSame($voiture, $utilisateur->getVoiture());
        $this->assertSame($utilisateur, $voiture->getUtilisateur()); // Vérifie que la relation est bien bidirectionnelle
    }

    public function testGetUserIdentifier(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail('jean.dupont@example.com');

        $this->assertEquals('jean.dupont@example.com', $utilisateur->getUserIdentifier());
    }

    public function testEraseCredentials(): void
    {
        $utilisateur = new Utilisateur();
        $this->assertNull($utilisateur->eraseCredentials()); // La méthode ne fait rien mais doit être testée
    }
}
