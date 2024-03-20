<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idprogramme = null;

    #[ORM\Column(length: 255)]
    private ?string $nomprogramme = null;

    #[ORM\Column]
    private ?int $idcoachp = null;

    #[ORM\Column]
    private ?int $dureeprogramme = null;

    #[ORM\Column]
    private ?int $evaluationprogramme = null;

    #[ORM\Column(length: 255)]
    private ?string $difficulteprogramme = null;

    private array $Listexercice = [];

    public function getidprogramme(): ?int
    {
        return $this->idprogramme;
    }

    public function getNomprogramme(): ?string
    {
        return $this->nomprogramme;
    }

    public function setNomprogramme(string $nomprogramme): static
    {
        $this->nomprogramme = $nomprogramme;

        return $this;
    }

    public function getIdcoachp(): ?int
    {
        return $this->idcoachp;
    }

    public function setIdcoachp(int $idcoachp): static
    {
        $this->idcoachp = $idcoachp;

        return $this;
    }

    public function getDureeprogramme(): ?int
    {
        return $this->dureeprogramme;
    }

    public function setDureeprogramme(int $dureeprogramme): static
    {
        $this->dureeprogramme = $dureeprogramme;

        return $this;
    }

    public function getEvaluationprogramme(): ?int
    {
        return $this->evaluationprogramme;
    }

    public function setEvaluationprogramme(int $evaluationprogramme): static
    {
        $this->evaluationprogramme = $evaluationprogramme;

        return $this;
    }

    public function getDifficulteprogramme(): ?string
    {
        return $this->difficulteprogramme;
    }

    public function setDifficulteprogramme(string $difficulteprogramme): static
    {
        $this->difficulteprogramme = $difficulteprogramme;

        return $this;
    }

    public function getListexercice(): array
    {
        return $this->Listexercice;
    }

    public function setListexercice(array $Listexercice): static
    {
        $this->Listexercice = $Listexercice;

        return $this;
    }
}
