<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $preparationTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cookingTime;

    /**
     * @ORM\OneToMany(targetEntity=Step::class, mappedBy="recipe", cascade={"persist","remove"})
     */
    private $steps;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="recipe", cascade={"persist","remove"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Quantity::class, mappedBy="recipe", cascade={"persist","remove"})
     */
    private $quantities;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favoriteRecipes")
     */
    private $users;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="recipe", cascade={"persist","remove"})
     */
    private $votes;


    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->quantities = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->votes = new ArrayCollection();
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

    public function getPreparationTime(): ?int
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(int $preparationTime): self
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): ?int
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?int $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    /**
     * @return Collection|Step[]
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps[] = $step;
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRecipe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quantity[]
     */
    public function getquantities(): Collection
    {
        return $this->quantities;
    }

    public function addQuantity(Quantity $Quantity): self
    {
        if (!$this->quantities->contains($Quantity)) {
            $this->quantities[] = $Quantity;
            $Quantity->setRecipe($this);
        }

        return $this;
    }

    public function removeQuantity(Quantity $Quantity): self
    {
        if ($this->quantities->removeElement($Quantity)) {
            // set the owning side to null (unless already changed)
            if ($Quantity->getRecipe() === $this) {
                $Quantity->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavoriteRecipe($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavoriteRecipe($this);
        }

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function addRating(): ?float
    {
        return $this->rating++;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setRecipe($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getRecipe() === $this) {
                $vote->setRecipe(null);
            }
        }

        return $this;
    }
}
