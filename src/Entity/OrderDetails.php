<?php

namespace App\Entity;

use App\Repository\OrderDetailsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: OrderDetailsRepository::class)]
#[ApiResource]
class OrderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $orders = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    private ?OrderReturns $orderReturns = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getOrderReturns(): ?OrderReturns
    {
        return $this->orderReturns;
    }

    public function setOrderReturns(?OrderReturns $orderReturns): self
    {
        $this->orderReturns = $orderReturns;

        return $this;
    }
}
