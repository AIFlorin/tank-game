<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BoardRepository")
 */
class Board
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\Column(type="integer")
     */
    private $obstacles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoardPosition", mappedBy="board", orphanRemoval=true)
     */
    private $boardPositions;

    public function __construct()
    {
        $this->boardPositions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getObstacles(): ?int
    {
        return $this->obstacles;
    }

    public function setObstacles(int $obstacles): self
    {
        $this->obstacles = $obstacles;

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
            $boardPosition->setBoard($this);
        }

        return $this;
    }

    public function removeBoardPosition(BoardPosition $boardPosition): self
    {
        if ($this->boardPositions->contains($boardPosition)) {
            $this->boardPositions->removeElement($boardPosition);
            // set the owning side to null (unless already changed)
            if ($boardPosition->getBoard() === $this) {
                $boardPosition->setBoard(null);
            }
        }

        return $this;
    }
}
