<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_voiture", type: "integer")]
    private ?int $idVoiture = null;

    #[ORM\Column(length: 100)]
    private ?string $marque = null;

    #[ORM\Column(length: 100)]
    private ?string $modele = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $immatriculation = null;

    #[ORM\Column(name: "nb_places", type: "integer")]
    private ?int $nbPlaces = null;

    #[ORM\OneToOne(targetEntity: Utilisateur::class, inversedBy: 'voiture')]
    #[ORM\JoinColumn(name: "id_utilisateur", referencedColumnName: "id_utilisateur", nullable: false)]
    private ?Utilisateur $utilisateur = null;


    public function getIdVoiture(): ?int
    {
        return $this->idVoiture;
    }
    public function setIdVoiture(?int $idVoiture): self
    {
        $this->idVoiture = $idVoiture;
        return $this;
    }
    public function getMarque(): ?string
    {
        return $this->marque;
    }
    public function setMarque(string $marque): self
    {
        $this->marque = $marque;
        return $this;
    }
    public function getModele(): ?string
    {
        return $this->modele;
    }
    public function setModele(string $modele): self
    {
        $this->modele = $modele;
        return $this;
    }
    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }
    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;
        return $this;
    }
    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }
    public function setNbPlaces(int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;
        return $this;
    }
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        if ($utilisateur !== null && $utilisateur->getVoiture() !== $this) {
            $utilisateur->setVoiture($this);
        }
        return $this;
    }
}
