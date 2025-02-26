<?php
namespace App\Entity;

use App\Enum\ReservationStatut;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_reservation", type: "integer")]
    private ?int $idReservation = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: "id_utilisateur", referencedColumnName: "id_utilisateur", nullable: false, onDelete: "CASCADE")]
    private ?Utilisateur $utilisateur = null;


    #[ORM\ManyToOne(targetEntity: Trajet::class)]
    #[ORM\JoinColumn(name: "id_trajet", referencedColumnName: "id_trajet", nullable: false, onDelete: "CASCADE")]
    private ?Trajet $trajet = null;


    #[ORM\Column(type: "string", enumType: ReservationStatut::class)]
    private ReservationStatut $statut = ReservationStatut::EN_ATTENTE;


    #[ORM\Column(name:"date_reservation", type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $dateReservation = null;

    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }
    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }
    public function setTrajet(Trajet $trajet): self
    {
        $this->trajet = $trajet;
        return $this;
    }
    public function getStatut(): ReservationStatut
    {
        return $this->statut;
    }
    public function setStatut(ReservationStatut $statut): self
    {
        $this->statut = $statut;
        return $this;
    }
    public function getDateReservation(): ?\DateTimeInterface
{
    return $this->dateReservation;
}

public function setDateReservation(\DateTimeInterface $dateReservation): self
{
    $this->dateReservation = $dateReservation;
    return $this;
}

}

