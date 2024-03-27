<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoRepository::class)]
class Promo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "code", type: "integer")]
    private ?int $code = null;

    #[ORM\Column]
    private ?float $pourcentage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $validite = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToOne(inversedBy: 'promos')]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'id')]
    private ?User $users = null;

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function getPourcentage(): ?float
    {
        return $this->pourcentage;
    }

    public function setPourcentage(float $pourcentage): static
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getValidite(): ?\DateTimeInterface
    {
        return $this->validite;
    }

    public function setValidite(\DateTimeInterface $validite): static
    {
        $this->validite = $validite;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }
}
