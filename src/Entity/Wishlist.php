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



    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'wishlists')]
    #[ORM\JoinColumn(name: 'idproduct', referencedColumnName: 'idproduct')]
    private ?Product $product = null;


    #[ORM\Column(length: 30)]
    private ?string $nameproduct = null;

    #[ORM\Column(length: 1000)]
    private ?string $image = null;

    #[ORM\Column(length: 1000)]
    private ?string $productdescription = null;

    #[ORM\Column]
    private ?float $priceproduct = null;

    #[ORM\ManyToOne(targetEntity: Product::class,inversedBy: 'wish')]
    private ?int $idproduct = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdproduct()
    {
        return $this->idproduct;
    }

    public function setIdproduct($product)
    {
        $this->idproduct = $product;

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
