<?php
namespace App\Entity;

use App\Enum\RoleType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_role", type: "integer")]
    private ?int $idRole = null;

    #[ORM\Column(name:"nom_role",type: "string", enumType: RoleType::class)]
    private RoleType $nomRole;

    public function getIdRole(): ?int
    {
        return $this->idRole;
    }

    public function getNomRole(): string
    {
        return $this->nomRole->value;
    }

    public function setNomRole(RoleType $nomRole): self
    {
        $this->nomRole = $nomRole;
        return $this;
    }
}
