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

    public function getOrd_status_id(): ?int
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

}
