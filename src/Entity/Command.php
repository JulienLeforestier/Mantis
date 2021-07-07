<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 */
class Command
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
    private $amount;

    /**
     * @ORM\Column(type="date")
     */
    private $registration_date;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commands")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=CommandLine::class, mappedBy="command", orphanRemoval=true)
     */
    private $commandLines;

    public function __construct()
    {
        $this->commandLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(\DateTimeInterface $registration_date): self
    {
        $this->registration_date = $registration_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $commandLine->setCommand($this);
        }

        return $this;
    }

    public function removeCommandLine(CommandLine $commandLine): self
    {
        if ($this->commandLines->removeElement($commandLine)) {
            // set the owning side to null (unless already changed)
            if ($commandLine->getCommand() === $this) {
                $commandLine->setCommand(null);
            }
        }

        return $this;
    }
}
