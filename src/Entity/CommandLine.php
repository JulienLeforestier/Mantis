<?php

namespace App\Entity;

use App\Repository\CommandLineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandLineRepository::class)
 */
class CommandLine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=command::class, inversedBy="commandLines")
     */
    private $command;

    /**
     * @ORM\ManyToOne(targetEntity=product::class, inversedBy="commandLines")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCommand(): ?command
    {
        return $this->command;
    }

    public function setCommand(?command $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getProduct(): ?product
    {
        return $this->product;
    }

    public function setProduct(?product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
