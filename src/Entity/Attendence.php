<?php

namespace App\Entity;

use App\Repository\AttendenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendenceRepository::class)]
class Attendence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $ClassId;

    #[ORM\Column(type: 'integer')]
    private $StudentId;

    #[ORM\Column(type: 'string', length: 25)]
    private $Status;

    #[ORM\Column(type: 'date')]
    private $Date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassId(): ?int
    {
        return $this->ClassId;
    }

    public function setClassId(int $ClassId): self
    {
        $this->ClassId = $ClassId;

        return $this;
    }

    public function getStudentId(): ?int
    {
        return $this->StudentId;
    }

    public function setStudentId(int $StudentId): self
    {
        $this->StudentId = $StudentId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }
}
