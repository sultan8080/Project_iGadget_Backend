<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReplyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReplyRepository::class)]
#[ApiResource]
class Reply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $subject = null;

    #[ORM\Column(length: 255)]
    private ?string $details = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $replyDate = null;

    #[ORM\ManyToOne(inversedBy: 'reply')]
    private ?Users $users = null;

    #[ORM\ManyToOne(inversedBy: 'reply')]
    private ?Messages $messages = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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

    public function getReplyDate(): ?\DateTimeImmutable
    {
        return $this->replyDate;
    }

    public function setReplyDate(\DateTimeImmutable $replyDate): self
    {
        $this->replyDate = $replyDate;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getMessages(): ?Messages
    {
        return $this->messages;
    }

    public function setMessages(?Messages $messages): self
    {
        $this->messages = $messages;

        return $this;
    }
}
