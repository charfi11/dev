<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AstuceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=AstuceRepository::class)
 */
class Astuce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="astuces")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="ast")
     */
    private $categoris;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="astuce")
     */
    private $vote;

    public function __construct()
    {
        $this->vote = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getCategoris(): ?Category
    {
        return $this->categoris;
    }

    public function setCategoris(?Category $categoris): self
    {
        $this->categoris = $categoris;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

     /**
     * @param User $user
     * @return boolean
     */

    public function isLikeByUser(User $user) :bool {

        foreach($this->votes as $votes){
            if($votes->getUser() === $user) return true;
        }

        return false;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVote(): Collection
    {
        return $this->vote;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->vote->contains($vote)) {
            $this->vote[] = $vote;
            $vote->setAstuce($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->vote->contains($vote)) {
            $this->vote->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getAstuce() === $this) {
                $vote->setAstuce(null);
            }
        }

        return $this;
    }
}
