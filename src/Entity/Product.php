<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $title;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=category::class, inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=mark::class, inversedBy="products")
     */
    private $mark;

    /**
     * @ORM\ManyToMany(targetEntity=producer::class, inversedBy="products")
     */
    private $producer;

    /**
     * @ORM\ManyToMany(targetEntity=type::class, inversedBy="products")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=CommandLine::class, mappedBy="product", orphanRemoval=true)
     */
    private $commandLines;

    /**
     * @ORM\OneToMany(targetEntity=Notice::class, mappedBy="product")
     */
    private $notices;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->mark = new ArrayCollection();
        $this->producer = new ArrayCollection();
        $this->type = new ArrayCollection();
        $this->commandLines = new ArrayCollection();
        $this->notices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|mark[]
     */
    public function getMark(): Collection
    {
        return $this->mark;
    }

    public function addMark(mark $mark): self
    {
        if (!$this->mark->contains($mark)) {
            $this->mark[] = $mark;
        }

        return $this;
    }

    public function removeMark(mark $mark): self
    {
        $this->mark->removeElement($mark);

        return $this;
    }

    /**
     * @return Collection|producer[]
     */
    public function getProducer(): Collection
    {
        return $this->producer;
    }

    public function addProducer(producer $producer): self
    {
        if (!$this->producer->contains($producer)) {
            $this->producer[] = $producer;
        }

        return $this;
    }

    public function removeProducer(producer $producer): self
    {
        $this->producer->removeElement($producer);

        return $this;
    }

    /**
     * @return Collection|type[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(type $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
        }

        return $this;
    }

    public function removeType(type $type): self
    {
        $this->type->removeElement($type);

        return $this;
    }

    /**
     * @return Collection|CommandLine[]
     */
    public function getCommandLines(): Collection
    {
        return $this->commandLines;
    }

    public function addCommandLine(CommandLine $commandLine): self
    {
        if (!$this->commandLines->contains($commandLine)) {
            $this->commandLines[] = $commandLine;
            $commandLine->setProduct($this);
        }

        return $this;
    }

    public function removeCommandLine(CommandLine $commandLine): self
    {
        if ($this->commandLines->removeElement($commandLine)) {
            // set the owning side to null (unless already changed)
            if ($commandLine->getProduct() === $this) {
                $commandLine->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notice[]
     */
    public function getNotices(): Collection
    {
        return $this->notices;
    }

    public function addNotice(Notice $notice): self
    {
        if (!$this->notices->contains($notice)) {
            $this->notices[] = $notice;
            $notice->setProduct($this);
        }

        return $this;
    }

    public function removeNotice(Notice $notice): self
    {
        if ($this->notices->removeElement($notice)) {
            // set the owning side to null (unless already changed)
            if ($notice->getProduct() === $this) {
                $notice->setProduct(null);
            }
        }

        return $this;
    }
}
