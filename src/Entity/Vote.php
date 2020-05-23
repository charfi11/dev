<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VoteRepository;

/**
 * @ORM\Entity(repositoryClass=VoteRepository::class)
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="votes")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Astuce::class, inversedBy="vote")
     */
    private $astuce;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAstuce(): ?Astuce
    {
        return $this->astuce;
    }

    public function setAstuce(?Astuce $astuce): self
    {
        $this->astuce = $astuce;

        return $this;
    }
}
