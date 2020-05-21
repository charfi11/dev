<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="categories")
     */
    private $cts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Link::class, mappedBy="categorie")
     */
    private $links;

    /**
     * @ORM\OneToMany(targetEntity=Astuce::class, mappedBy="categoris")
     */
    private $ast;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="categori")
     */
    private $questions;

    public function __construct()
    {
        $this->links = new ArrayCollection();
        $this->ast = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCts(): ?Theme
    {
        return $this->cts;
    }

    public function setCts(?Theme $cts): self
    {
        $this->cts = $cts;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

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

    /**
     * @return Collection|Link[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setCategorie($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getCategorie() === $this) {
                $link->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Astuce[]
     */
    public function getAst(): Collection
    {
        return $this->ast;
    }

    public function addAst(Astuce $ast): self
    {
        if (!$this->ast->contains($ast)) {
            $this->ast[] = $ast;
            $ast->setCategoris($this);
        }

        return $this;
    }

    public function removeAst(Astuce $ast): self
    {
        if ($this->ast->contains($ast)) {
            $this->ast->removeElement($ast);
            // set the owning side to null (unless already changed)
            if ($ast->getCategoris() === $this) {
                $ast->setCategoris(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setCategori($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getCategori() === $this) {
                $question->setCategori(null);
            }
        }

        return $this;
    }
}
