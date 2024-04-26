<?php

namespace App\Entity;

use App\Repository\ShoppingcartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingcartRepository::class)]
class Shoppingcart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idshoppingcart")]
    private ?int $idshoppingcart = null;

    #[ORM\Column]
    private ?int $iduser = null;

    #[ORM\Column(name: "idproduct")] // Specify the column name for idproduct
    private ?int $idproduct = null;

    #[ORM\Column(length: 30)]
    private ?string $nameproduct = null;

    #[ORM\Column(length: 1000)]
    private ?string $image = null;

    #[ORM\Column(length: 1000)]
    private ?string $productdescription = null;

    #[ORM\Column]
    private ?float $priceproduct = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: "shoppingcarts", cascade: ["persist"])]
    #[ORM\JoinTable(
        name: "shoppingcart_product",
        joinColumns: [
            new ORM\JoinColumn(name: "shoppingcart_id", referencedColumnName: "idshoppingcart")
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: "product_id", referencedColumnName: "idproduct")
        ]
    )]
    private Collection $products; // Update property name to be more descriptive

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getIdshoppingcart(): ?int
    {
        return $this->idshoppingcart;
    }

    public function setIdshoppingcart(?int $idshoppingcart): self
    {
        $this->idshoppingcart = $idshoppingcart;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdproduct(): ?int
    {
        return $this->idproduct;
    }

    public function setIdproduct(?int $idproduct): self
    {
        $this->idproduct = $idproduct;

        return $this;
    }

    public function getNameproduct(): ?string
    {
        return $this->nameproduct;
    }

    public function setNameproduct(?string $nameproduct): self
    {
        $this->nameproduct = $nameproduct;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getProductdescription(): ?string
    {
        return $this->productdescription;
    }

    public function setProductdescription(?string $productdescription): self
    {
        $this->productdescription = $productdescription;

        return $this;
    }

    public function getPriceproduct(): ?float
    {
        return $this->priceproduct;
    }

    public function setPriceproduct(?float $priceproduct): self
    {
        $this->priceproduct = $priceproduct;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
}
