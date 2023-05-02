<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Users $users = null;

    #[ORM\OneToMany(mappedBy: 'messages', targetEntity: Reply::class)]
    private Collection $reply;

    public function __construct()
    {
        $this->reply = new ArrayCollection();
    }

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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Reply>
     */
    public function getReply(): Collection
    {
        return $this->reply;
    }

    public function addReply(Reply $reply): self
    {
        if (!$this->reply->contains($reply)) {
            $this->reply->add($reply);
            $reply->setMessages($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->reply->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getMessages() === $this) {
                $reply->setMessages(null);
            }
        }

        return $this;
    }
}
