<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    private $Name;

    #[ORM\Column(type: 'integer')]
    private $Admission_Number;

    #[ORM\ManyToOne(targetEntity: Classes::class, inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private $classs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getAdmissionNumber(): ?int
    {
        return $this->Admission_Number;
    }

    public function setAdmissionNumber(int $Admission_Number): self
    {
        $this->Admission_Number = $Admission_Number;

        return $this;
    }

    public function getClasss(): ?Classes
    {
        return $this->classs;
    }

    public function setClasss(?Classes $classs): self
    {
        $this->classs = $classs;

        return $this;
    }
}
