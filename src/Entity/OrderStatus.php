<?php

namespace App\Entity;

use App\Repository\OrderStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderStatusRepository::class)]
class OrderStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $ord_status_id = null;

    #[ORM\Column(length: 100)]
    private ?string $typeStatus = null;

    #[ORM\OneToOne(mappedBy: 'orderStatus', cascade: ['persist', 'remove'])]
    private ?Order $orders = null;

    public function getId(): ?int
    {
        return $this->ord_status_id;
    }

    public function getTypeStatus(): ?string
    {
        return $this->typeStatus;
    }

    public function setTypeStatus(string $typeStatus): self
    {
        $this->typeStatus = $typeStatus;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(Order $orders): self
    {
        // set the owning side of the relation if necessary
        if ($orders->getOrderStatus() !== $this) {
            $orders->setOrderStatus($this);
        }

        $this->orders = $orders;

        return $this;
    }
}
