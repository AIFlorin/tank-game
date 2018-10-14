<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\GameActionRepository")
 */
class GameAction
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
     * @ORM\Column(type="integer")
     */
    private $damage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BoardPosition")
     */
    private $move;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameScore", inversedBy="actions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameScore;

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

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getMove(): ?BoardPosition
    {
        return $this->move;
    }

    public function setMove(?BoardPosition $move): self
    {
        $this->move = $move;

        return $this;
    }

    public function getGameScore(): ?GameScore
    {
        return $this->gameScore;
    }

    public function setGameScore(?GameScore $gameScore): self
    {
        $this->gameScore = $gameScore;

        return $this;
    }
}
