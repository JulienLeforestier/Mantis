<?php

namespace App\Entity;

use App\Repository\PromotionalCodeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionalCodeRepository::class)
 */
class PromotionalCode
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
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $reduction;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="promotionalCodes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function setReduction(int $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
