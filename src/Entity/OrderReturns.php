<?php

namespace App\Entity;

use App\Repository\OrderReturnsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'orderReturns', targetEntity: OrderDetails::class)]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, OrderDetails>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setOrderReturns($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrderReturns() === $this) {
                $orderDetail->setOrderReturns(null);
            }
        }

        return $this;
    }
}
