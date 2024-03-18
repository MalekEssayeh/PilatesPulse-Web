<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ExerciceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idexercice = null;

    #[ORM\Column(length: 255)]
    
    private ?string $nomexercice = null;

    #[ORM\Column]
    private ?int $idcoach = null;

    #[ORM\Column(length: 255)]
    private ?string $Difficulteexercice = null;

    #[ORM\Column]
    private ?int $Evaluationexercice = null;

    #[ORM\Column(length: 255)]
    private ?string $Muscle = null;

    #[ORM\Column(length: 255)]
    private ?string $Demonstration = null;

    #[ORM\Column(length: 255)]
    private ?string $Video = null;

    public function getId(): ?int
    {
        return $this->idexercice;
    }

    public function getnomexercice(): ?string
    {
        return $this->nomexercice;
    }

    public function setnomexercice(string $e): static
    {
        $this->nomexercice = $e;

        return $this;
    }

    public function getIdcoach(): ?int
    {
        return $this->idcoach;
    }

    public function setIdcoach(int $idcoach): static
    {
        $this->idcoach = $idcoach;

        return $this;
    }

    public function getDifficulteExercice(): ?string
    {
        return $this->Difficulteexercice;
    }

    public function setDifficulteExercice(string $DifficulteExercice): static
    {
        $this->Difficulteexercice = $DifficulteExercice;

        return $this;
    }

    public function getEvaluationexercice(): ?int
    {
        return $this->Evaluationexercice;
    }

    public function setEvaluationexercice(int $e): static
    {
        $this->Evaluationexercice = $e;

        return $this;
    }

    public function getMuscle(): ?string
    {
        return $this->Muscle;
    }

    public function setMuscle(string $Muscle): static
    {
        $this->Muscle = $Muscle;

        return $this;
    }

    public function getDemonstration(): ?string
    {
        return $this->Demonstration;
    }

    public function setDemonstration(string $Demonstration): static
    {
        $this->Demonstration = $Demonstration;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->Video;
    }

    public function setVideo(?string $Video): static
    {
        $this->Video = $Video;

        return $this;
    }
}
