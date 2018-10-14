<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\BattleFieldCreatorAction;
use App\Controller\BattleFieldSimulatorAction;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "post"={
 *              "method"="POST",
 *              "controller"=BattleFieldCreatorAction::class
 *          }
 *     },
 *     itemOperations={
 *          "simulate"={
 *              "method"="PUT",
 *              "path"="/battle_fields/{id}/simulate",
 *              "controller"=BattleFieldSimulatorAction::class
 *          },
 *          "get"={"method"="GET"},
 *          "put"={"method"="PUT"},
 *          "delete"={"method"="DELETE"},
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\BattleFieldRepository")
 */
class BattleField
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Board")
     * @ORM\JoinColumn(nullable=false)
     */
    private $board;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameScore", mappedBy="battleField", cascade={"persist"})
     */
    private $gameScores;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\BoardPosition",
     *     mappedBy="battleField",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private $boardPositions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"persist"})
     */
    private $playingUsers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BattleFieldTank", mappedBy="battleField", cascade={"persist"})
     */
    private $battleFieldTank;

    public function __construct()
    {
        $this->gameScores = new ArrayCollection();
        $this->boardPositions = new ArrayCollection();
        $this->playingUsers = new ArrayCollection();
        $this->battleFieldTank = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoard(): ?Board
    {
        return $this->board;
    }

    public function setBoard(?Board $board): self
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return Collection|GameScore[]
     */
    public function getGameScores(): Collection
    {
        return $this->gameScores;
    }

    public function addGameScore(GameScore $gameScore): self
    {
        if (!$this->gameScores->contains($gameScore)) {
            $this->gameScores[] = $gameScore;
            $gameScore->setBattleField($this);
        }

        return $this;
    }

    public function removeGameScore(GameScore $gameScore): self
    {
        if ($this->gameScores->contains($gameScore)) {
            $this->gameScores->removeElement($gameScore);
            // set the owning side to null (unless already changed)
            if ($gameScore->getBattleField() === $this) {
                $gameScore->setBattleField(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BoardPosition[]
     */
    public function getBoardPositions(): Collection
    {
        return $this->boardPositions;
    }

    public function addBoardPosition(BoardPosition $boardPosition): self
    {
        if (!$this->boardPositions->contains($boardPosition)) {
            $this->boardPositions[] = $boardPosition;
            $boardPosition->setBattleField($this);
        }

        return $this;
    }

    public function removeBoardPosition(BoardPosition $boardPosition): self
    {
        if ($this->boardPositions->contains($boardPosition)) {
            $this->boardPositions->removeElement($boardPosition);
            // set the owning side to null (unless already changed)
            if ($boardPosition->getBattleField() === $this) {
                $boardPosition->setBattleField(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getPlayingUsers(): Collection
    {
        return $this->playingUsers;
    }

    public function addPlayingUser(User $playingUser): self
    {
        if (!$this->playingUsers->contains($playingUser)) {
            $this->playingUsers[] = $playingUser;
        }

        return $this;
    }

    public function removePlayingUser(User $playingUser): self
    {
        if ($this->playingUsers->contains($playingUser)) {
            $this->playingUsers->removeElement($playingUser);
        }

        return $this;
    }

    /**
     * @return Collection|BattleFieldTank[]
     */
    public function getBattleFieldTank(): Collection
    {
        return $this->battleFieldTank;
    }

    public function addBattleFieldTank(BattleFieldTank $battleFieldTank): self
    {
        if (!$this->battleFieldTank->contains($battleFieldTank)) {
            $this->battleFieldTank[] = $battleFieldTank;
            $battleFieldTank->setBattleField($this);
        }

        return $this;
    }

    public function removeBattleFieldTank(BattleFieldTank $battleFieldTank): self
    {
        if ($this->battleFieldTank->contains($battleFieldTank)) {
            $this->battleFieldTank->removeElement($battleFieldTank);
            // set the owning side to null (unless already changed)
            if ($battleFieldTank->getBattleField() === $this) {
                $battleFieldTank->setBattleField(null);
            }
        }

        return $this;
    }
}
