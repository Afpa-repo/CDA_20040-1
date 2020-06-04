<?php

namespace App\Entity;

use App\Repository\SuppliersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SuppliersRepository::class)
 */
class Suppliers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CompagnyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $HeadOffice;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $Tel;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $Mail;

    /**
     * @Groups("product_details")
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="supplier", orphanRemoval=true)
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompagnyName(): ?string
    {
        return $this->CompagnyName;
    }

    public function setCompagnyName(string $CompagnyName): self
    {
        $this->CompagnyName = $CompagnyName;

        return $this;
    }

    public function getHeadOffice(): ?string
    {
        return $this->HeadOffice;
    }

    public function setHeadOffice(string $HeadOffice): self
    {
        $this->HeadOffice = $HeadOffice;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->Tel;
    }

    public function setTel(string $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSupplier($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getSupplier() === $this) {
                $product->setSupplier(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->CompagnyName;
    }
}
