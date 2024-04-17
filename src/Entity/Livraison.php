<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $methodePay = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseLiv = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateLiv = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'livraison')]
    private Collection $idCmd;

    public function __construct()
    {
        $this->idCmd = new ArrayCollection();
        $this->etat = "En cours";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethodePay(): ?string
    {
        return $this->methodePay;
    }

    public function setMethodePay(string $methodePay): static
    {
        $this->methodePay = $methodePay;

        return $this;
    }

    public function getAdresseLiv(): ?string
    {
        return $this->adresseLiv;
    }

    public function setAdresseLiv(string $adresseLiv): static
    {
        $this->adresseLiv = $adresseLiv;

        return $this;
    }

    public function getDateLiv(): ?\DateTimeInterface
    {
        return $this->dateLiv;
    }

    public function setDateLiv(\DateTimeInterface $dateLiv): static
    {
        $this->dateLiv = $dateLiv;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getIdCmd(): Collection
    {
        return $this->idCmd;
    }

    public function addIdCmd(Commande $idCmd): static
    {
        if (!$this->idCmd->contains($idCmd)) {
            $this->idCmd->add($idCmd);
            $idCmd->setLivraison($this);
        }

        return $this;
    }

    public function removeIdCmd(Commande $idCmd): static
    {
        if ($this->idCmd->removeElement($idCmd)) {
            // set the owning side to null (unless already changed)
            if ($idCmd->getLivraison() === $this) {
                $idCmd->setLivraison(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->adresseLiv;
    }
    
}
