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
     * @ORM\ManyToOne(targetEntity=Astuce::class, inversedBy="votes")
     */
    private $astuces;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="votes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAstuces(): ?Astuce
    {
        return $this->astuces;
    }

    public function setAstuces(?Astuce $astuces): self
    {
        $this->astuces = $astuces;

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
}
