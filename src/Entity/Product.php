<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idproduct = null;

    #[ORM\Column(length: 30)]
    private ?string $nameproduct = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 1000, nullable: true)]
    #[Assert\NotBlank(message: "Description is required.")]
    #[Assert\Type(type: "string", message: "Product description must be a string.")]
    #[Assert\Length(max: 1000, maxMessage: "Product description cannot be longer than {{ limit }} characters.")]
    private ?string $productdescription = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Description is required.")]
    private ?float $priceproduct = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Description is required.")]
    private ?int $stock = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'idcategory', referencedColumnName: 'idcategory')]
    private ?Category $idcategory = null;

    #[ORM\OneToMany(mappedBy: 'idproduct', targetEntity: Wishlist::class)]
    private Collection $wishlists;

    public function __construct()
    {
        $this->wishlists = new ArrayCollection();
    }

    /*#[ORM\ManyToMany(targetEntity: Shoppingcart::class, mappedBy: 'idproduct')]
    private Collection $shoppingcarts;*/

    /*public function __construct()
    {
        $this->shoppingcarts = new ArrayCollection();
    }*/


        public function getIdproduct(): ?int
    {
        return $this->idproduct;
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

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getProductdescription(): ?string
    {
        return $this->productdescription;
    }

    public function setProductdescription(?string $productdescription): static
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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getIdcategory(): ?Category
    {
        return $this->idcategory;
    }

    public function setIdcategory(?Category $idcategory): static
    {
        $this->idcategory = $idcategory;

        return $this;
    }
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nameproduct;
    }

    /**
     * @return Collection<int, Shoppingcart>
     */
    public function getShoppingcarts(): Collection
    {
        return $this->shoppingcarts;
    }

    public function addShoppingcart(Shoppingcart $shoppingcart): static
    {
        if (!$this->shoppingcarts->contains($shoppingcart)) {
            $this->shoppingcarts->add($shoppingcart);
            $shoppingcart->addIdproduct($this);
        }

        return $this;
    }

    public function removeShoppingcart(Shoppingcart $shoppingcart): static
    {
        if ($this->shoppingcarts->removeElement($shoppingcart)) {
            $shoppingcart->removeIdproduct($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Wishlist>
     */
    public function getWishlists(): Collection
    {
        return $this->wishlists;
    }

    public function addWishlist(Wishlist $wishlist): static
    {
        if (!$this->wishlists->contains($wishlist)) {
            $this->wishlists->add($wishlist);
            $wishlist->setIdproduct($this);
        }

        return $this;
    }

    public function removeWishlist(Wishlist $wishlist): static
    {
        if ($this->wishlists->removeElement($wishlist)) {
            // set the owning side to null (unless already changed)
            if ($wishlist->getIdproduct() === $this) {
                $wishlist->setIdproduct(null);
            }
        }

        return $this;
    }




}
