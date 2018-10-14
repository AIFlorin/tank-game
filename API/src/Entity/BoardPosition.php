<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Interfaces\PositionInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BoardPositionRepository")
 */
class BoardPosition implements PositionInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Board", inversedBy="boardPositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $board;

    /**
     * @ORM\Column(type="integer")
     */
    private $xCoordinate;

    /**
     * @ORM\Column(type="integer")
     */
    private $yCoordinate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasObstacle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BattleField", inversedBy="boardPositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $battleField;

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

    public function getXCoordinate(): ?int
    {
        return $this->xCoordinate;
    }

    public function setXCoordinate(int $xCoordinate): self
    {
        $this->xCoordinate = $xCoordinate;

        return $this;
    }

    public function getYCoordinate(): ?int
    {
        return $this->yCoordinate;
    }

    public function setYCoordinate(int $yCoordinate): self
    {
        $this->yCoordinate = $yCoordinate;

        return $this;
    }

    public function getHasObstacle(): ?bool
    {
        return $this->hasObstacle;
    }

    public function setHasObstacle(bool $hasObstacle): self
    {
        $this->hasObstacle = $hasObstacle;

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
