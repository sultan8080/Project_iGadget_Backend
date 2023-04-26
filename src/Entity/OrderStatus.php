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

    #[ORM\Column(length: 255)]
    private ?string $OrderStatus = null;

    public function getId(): ?int
    {
        return $this->ord_status_id;
    }

    public function getOrderStatus(): ?string
    {
        return $this->OrderStatus;
    }

    public function setOrderStatus(string $OrderStatus): self
    {
        $this->OrderStatus = $OrderStatus;

        return $this;
    }
}
