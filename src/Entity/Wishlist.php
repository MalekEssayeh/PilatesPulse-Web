<?php

namespace App\Entity;

use App\Repository\WishlistRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WishlistRepository::class)]
class Wishlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'wishlists')]
    private ?Product $idproduct = null;

    #[ORM\Column(length: 30)]
    private ?string $nameproduct = null;

    #[ORM\Column(length: 1000)]
    private ?string $image = null;

    #[ORM\Column(length: 1000)]
    private ?string $productdescription = null;

    #[ORM\Column]
    private ?float $priceproduct = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNameproduct(): ?string
    {
        return $this->nameproduct;
    }

    public function setNameproduct(string $nameproduct): static
    {
        $this->nameproduct = $nameproduct;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getProductdescription(): ?string
    {
        return $this->productdescription;
    }

    public function setProductdescription(string $productdescription): static
    {
        $this->productdescription = $productdescription;

        return $this;
    }

    public function getPriceproduct(): ?float
    {
        return $this->priceproduct;
    }

    public function setPriceproduct(float $priceproduct): static
    {
        $this->priceproduct = $priceproduct;

        return $this;
    }
}
