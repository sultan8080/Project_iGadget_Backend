<?php

namespace App\Entity;

use App\Repository\ReplyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReplyRepository::class)]
class Reply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $reply_id = null;

    #[ORM\Column(length: 100)]
    private ?string $subject = null;

    #[ORM\Column(length: 255)]
    private ?string $details = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $replyDate = null;

    public function getId(): ?int
    {
        return $this->reply_id;
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
}
