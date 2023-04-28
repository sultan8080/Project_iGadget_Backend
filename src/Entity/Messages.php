<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $subjet = null;

    #[ORM\Column(length: 255)]
    private ?string $details = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $messagecreatedate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubjet(): ?string
    {
        return $this->subjet;
    }

    public function setSubjet(string $subjet): self
    {
        $this->subjet = $subjet;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getMessagecreatedate(): ?\DateTimeImmutable
    {
        return $this->messagecreatedate;
    }

    public function setMessagecreatedate(\DateTimeImmutable $messagecreatedate): self
    {
        $this->messagecreatedate = $messagecreatedate;

        return $this;
    }
}
