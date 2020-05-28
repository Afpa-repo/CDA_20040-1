<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $TotalCost;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="cartorder", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ordercart;

    /**
     * @ORM\ManyToMany(targetEntity=Products::class, inversedBy="cart")
     */
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getTotalCost(): ?float
    {
        return $this->TotalCost;
    }

    public function setTotalCost(float $TotalCost): self
    {
        $this->TotalCost = $TotalCost;

        return $this;
    }

    public function getOrdercart(): ?Order
    {
        return $this->ordercart;
    }

    public function setOrdercart(?Order $ordercart): self
    {
        $this->ordercart = $ordercart;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->product->contains($product)) {
            $this->product->removeElement($product);
        }

        return $this;
    }
}
