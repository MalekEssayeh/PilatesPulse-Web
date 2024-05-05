<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idrating = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'idproduct')]
    #[ORM\JoinColumn(name: 'idproduct', referencedColumnName: 'idproduct')]
    private ?Product $idproduct = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: 'iduser', referencedColumnName: 'id')]
    private ?User $iduser = null;

    #[ORM\Column]
    private ?float $nbstars = null;

    public function getId(): ?int
    {
        return $this->idrating;
    }

    public function getIdproduct(): ?Product
    {
        return $this->idproduct;
    }

    public function setIdproduct(?Product $idproduct): static
    {
        $this->idproduct = $idproduct;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getNbstars(): ?float
    {
        return $this->nbstars;
    }

    public function setNbstars(float $nbstars): static
    {
        $this->nbstars = $nbstars;

        return $this;
    }
}
