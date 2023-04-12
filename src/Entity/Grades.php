<?php

namespace App\Entity;

use App\Repository\GradesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradesRepository::class)]
class Grades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $avgGrade = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvgGrade(): ?int
    {
        return $this->avgGrade;
    }

    public function setAvgGrade(int $avgGrade): self
    {
        $this->avgGrade = $avgGrade;

        return $this;
    }
}
