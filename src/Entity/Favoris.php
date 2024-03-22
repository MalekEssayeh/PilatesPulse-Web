<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavorisRepository::class)]
class Favoris
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idprogramme = null;

    #[ORM\Column]
    private ?int $iduser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdprogramme(): ?int
    {
        return $this->idprogramme;
    }

    public function setIdprogramme(int $idprogramme): static
    {
        $this->idprogramme = $idprogramme;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }
}
