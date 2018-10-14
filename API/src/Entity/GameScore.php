<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\GameScoreRepository")
 */
class GameScore
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="gameScore")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isWon;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\GameAction",
     *     mappedBy="gameScore",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private $actions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BattleField", inversedBy="gameScores", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $battleField;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

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

    public function getIsWon(): ?bool
    {
        return $this->isWon;
    }

    public function setIsWon(bool $isWon): self
    {
        $this->isWon = $isWon;

        return $this;
    }

    /**
     * @return Collection|GameAction[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(GameAction $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setGameScore($this);
        }

        return $this;
    }

    public function removeAction(GameAction $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getGameScore() === $this) {
                $action->setGameScore(null);
            }
        }

        return $this;
    }

    public function getBattleField(): ?BattleField
    {
        return $this->battleField;
    }

    public function setBattleField(?BattleField $battleField): self
    {
        $this->battleField = $battleField;

        return $this;
    }
}
