<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
#[ORM\Table(name: "utilisateur")]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_utilisateur", type: "integer")]
    private ?int $idUtilisateur = null;

    #[ORM\Column(length: 200)]
    private ?string $nom = null;

    #[ORM\Column(length: 200)]
    private ?string $prenom = null;

    #[ORM\Column(length: 200, unique: true)]
    private ?string $email = null;

    #[ORM\Column(name: "mot_de_passe", type: "string", length: 60)]
    private ?string $motDePasse = null;

    #[ORM\ManyToOne(targetEntity: Role::class)]
    #[ORM\JoinColumn(name: "id_role", referencedColumnName: "id_role", nullable: false)]
    private ?Role $role = null;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: "id_ville", referencedColumnName: "id_ville", nullable: false)]
    private ?Ville $ville = null;

    #[ORM\OneToOne(targetEntity: Voiture::class, mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Voiture $voiture = null;


    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    public function setPassword(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }


    public function getRoles(): array
    {
        return [$this->role ? 'ROLE_' . strtoupper($this->role->getNomRole()) : 'ROLE_UTILISATEUR'];
    }


    public function getRoleEntity(): ?Role
    {
        return $this->role;
    }

    public function setRoleEntity(Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(Ville $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;
        if ($voiture !== null && $voiture->getUtilisateur() !== $this) {
            $voiture->setUtilisateur($this);
        }
        return $this;
    }


    public function getUserIdentifier(): string
    {
        return $this->email;
    }


    public function eraseCredentials(): void
    {
       
    }
}
