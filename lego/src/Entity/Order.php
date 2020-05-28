<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
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
    private $DeliveryAdress;

    /**
     * @ORM\Column(type="datetime")
     */
    private $OrderDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DeliveryDate;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $Status;

    /**
     * @ORM\Column(type="float")
     */
    private $ShippingPrice;

    /**
     * @ORM\OneToMany(targetEntity=Cart::class, mappedBy="ordercart", cascade={"persist", "remove"})
     */
    private $cartorder;

    public function __construct()
    {
        $this->cartorder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliveryAdress(): ?string
    {
        return $this->DeliveryAdress;
    }

    public function setDeliveryAdress(string $DeliveryAdress): self
    {
        $this->DeliveryAdress = $DeliveryAdress;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->OrderDate;
    }

    public function setOrderDate(\DateTimeInterface $OrderDate): self
    {
        $this->OrderDate = $OrderDate;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->DeliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $DeliveryDate): self
    {
        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getShippingPrice(): ?float
    {
        return $this->ShippingPrice;
    }

    public function setShippingPrice(float $ShippingPrice): self
    {
        $this->ShippingPrice = $ShippingPrice;

        return $this;
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCartorder(): Collection
    {
        return $this->cartorder;
    }

    public function setCartorder(Cart $cartorder): self
    {
        $this->cartorder = $cartorder;

        // set the owning side of the relation if necessary
        if ($cartorder->getOrdercart() !== $this) {
            $cartorder->setOrdercart($this);
        }

        return $this;
    }

    public function addCartorder(Cart $cartorder): self
    {
        if (!$this->cartorder->contains($cartorder)) {
            $this->cartorder[] = $cartorder;
            $cartorder->setOrdercart($this);
        }

        return $this;
    }

    public function removeCartorder(Cart $cartorder): self
    {
        if ($this->cartorder->contains($cartorder)) {
            $this->cartorder->removeElement($cartorder);
            // set the owning side to null (unless already changed)
            if ($cartorder->getOrdercart() === $this) {
                $cartorder->setOrdercart(null);
            }
        }

        return $this;
    }


}
