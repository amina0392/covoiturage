<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_ville", type: "integer")]
    private ?int $idVille = null;

    #[ORM\Column(name:"code_postale", type: "string", length: 10)]
    private ?string $codePostale = null;

    #[ORM\Column(name:"nom_commune", type: "string", length: 200)]
    private ?string $nomCommune = null;

    public function getIdVille(): ?int { return $this->idVille; }
    public function getCodePostale(): ?string { return $this->codePostale; }
    public function setCodePostale(string $codePostale): self { $this->codePostale = $codePostale; return $this; }
    public function getNomCommune(): ?string { return $this->nomCommune; }
    public function setNomCommune(string $nomCommune): self { $this->nomCommune = $nomCommune; return $this; }
}
