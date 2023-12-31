<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\DateFilter;
use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;



#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['media_object:read']],
    filters: ['offer.date_filter']
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'name' => 'partial'
    ]
)]
class Products
{
    #[Groups(['media_object:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['media_object:read'])]
    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[Groups(['media_object:read'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['media_object:read'])]
    #[ORM\Column]
    private ?float $price = null;

    #[Groups(['media_object:read'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups(['media_object:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimension = null;

    #[Groups(['media_object:read'])]
    #[ORM\Column]
    private ?bool $stock = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Users $users = null;

    #[ORM\ManyToMany(targetEntity: ProductTags::class, inversedBy: 'products')]
    private Collection $producttags;

    #[Groups(['media_object:read'])]
    #[ORM\OneToMany(mappedBy: 'products', targetEntity: ProductImages::class, orphanRemoval: true, fetch: 'EAGER')]
    private Collection $productimages;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categories = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable('now');
        $this->producttags = new ArrayCollection();
        $this->productimages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(?string $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function isStock(): ?bool
    {
        return $this->stock;
    }

    public function setStock(bool $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    #[Groups(['media_object:read'])]
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
     * @return Collection<int, ProductTags>
     */
    public function getProducttags(): Collection
    {
        return $this->producttags;
    }

    public function addProducttag(ProductTags $producttag): self
    {
        if (!$this->producttags->contains($producttag)) {
            $this->producttags->add($producttag);
        }

        return $this;
    }

    public function removeProducttag(ProductTags $producttag): self
    {
        $this->producttags->removeElement($producttag);

        return $this;
    }

    /**
     * @return Collection<int, ProductImages>
     */
    public function getProductimages(): Collection
    {
        // dd($this->productimages);
        return $this->productimages;
    }

    public function addProductimage(ProductImages $productimage): self
    {
        if (!$this->productimages->contains($productimage)) {
            $this->productimages->add($productimage);
            $productimage->setProducts($this);
        }

        return $this;
    }

    public function removeProductimage(ProductImages $productimage): self
    {
        if ($this->productimages->removeElement($productimage)) {
            // set the owning side to null (unless already changed)
            if ($productimage->getProducts() === $this) {
                $productimage->setProducts(null);
            }
        }

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
