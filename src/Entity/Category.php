<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcategory = null;

    #[ORM\Column(length: 30)]
    private ?string $namecat = null;

    #[ORM\OneToMany(mappedBy: 'idcategory', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getIdcategory(): ?int
    {
        return $this->idcategory;
    }

    public function getNamecat(): ?string
    {
        return $this->namecat;
    }

    public function setNamecat(string $namecat): static
    {
        $this->namecat = $namecat;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setIdcategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getIdcategory() === $this) {
                $product->setIdcategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->namecat ?? '';
    }
}
