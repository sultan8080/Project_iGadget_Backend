<?php

namespace App\Entity;

use App\Repository\OrderReturnsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderReturnsRepository::class)]
class OrderReturns
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $returncreatedate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReturncreatedate(): ?\DateTimeImmutable
    {
        return $this->returncreatedate;
    }

    public function setReturncreatedate(\DateTimeImmutable $returncreatedate): self
    {
        $this->returncreatedate = $returncreatedate;

        return $this;
    }
}
