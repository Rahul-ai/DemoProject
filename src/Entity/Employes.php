<?php

namespace App\Entity;

use App\Repository\EmployesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployesRepository::class)]
class Employes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $EmployeeCode;

    #[ORM\Column(type: 'string', length: 25)]
    private $Role;

    #[ORM\Column(type: 'boolean')]
    private $IsDeleted;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeCode(): ?int
    {
        return $this->EmployeeCode;
    }

    public function setEmployeeCode(int $EmployeeCode): self
    {
        $this->EmployeeCode = $EmployeeCode;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): self
    {
        $this->Role = $Role;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->IsDeleted;
    }

    public function setIsDeleted(bool $IsDeleted): self
    {
        $this->IsDeleted = $IsDeleted;

        return $this;
    }
}
