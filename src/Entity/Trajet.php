<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "trajet")]
class Trajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_trajet", type: "integer")]
    private ?int $idTrajet = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: "id_utilisateur", referencedColumnName: "id_utilisateur", nullable: false, onDelete: "CASCADE")]
    private ?Utilisateur $conducteur = null;

    #[ORM\Column(name: "date_heure", type: "datetime")]
    private ?\DateTimeInterface $dateHeure = null;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: "id_ville_depart", referencedColumnName: "id_ville", nullable: false)]
    private ?Ville $villeDepart = null;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: "id_ville_arrivee", referencedColumnName: "id_ville", nullable: false)]
    private ?Ville $villeArrivee = null;

    #[ORM\Column(name: "places_restantes", type: "integer")]
    private ?int $placesRestantes = null;

    #[ORM\Column(name: "detail_trajet", type: "text", nullable: true)]
    private ?string $detailTrajet = null;


    public function getIdTrajet(): ?int { return $this->idTrajet; }
    public function getConducteur(): ?Utilisateur { return $this->conducteur; }
    public function setConducteur(Utilisateur $conducteur): self { $this->conducteur = $conducteur; return $this; }
    public function getDateHeure(): ?\DateTimeInterface { return $this->dateHeure; }
    public function setDateHeure(\DateTimeInterface $dateHeure): self { $this->dateHeure = $dateHeure; return $this; }
    public function getVilleDepart(): ?Ville { return $this->villeDepart; }
    public function setVilleDepart(Ville $villeDepart): self { $this->villeDepart = $villeDepart; return $this; }
    public function getVilleArrivee(): ?Ville { return $this->villeArrivee; }
    public function setVilleArrivee(Ville $villeArrivee): self { $this->villeArrivee = $villeArrivee; return $this; }
    public function getPlacesRestantes(): ?int { return $this->placesRestantes; }
    public function setPlacesRestantes(int $placesRestantes): self { $this->placesRestantes = $placesRestantes; return $this; }
    public function getDetailTrajet(): ?string { return $this->detailTrajet; }
    public function setDetailTrajet(?string $detailTrajet): self { $this->detailTrajet = $detailTrajet; return $this; }
}
