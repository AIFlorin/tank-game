<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BattleFieldTankRepository")
 */
class BattleFieldTank
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tank")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tank;

    /**
     * @ORM\Column(type="integer")
     */
    private $health;

    /**
     * @ORM\Column(type="integer")
     */
    private $armure;

    /**
     * @ORM\Column(type="integer")
     */
    private $damage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BattleField", inversedBy="battleFieldTank")
     */
    private $battleField;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $xCoordinate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yCoordinate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTank(): ?Tank
    {
        return $this->tank;
    }

    public function setTank(?Tank $tank): self
    {
        $this->tank = $tank;

        return $this;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getArmure(): ?int
    {
        return $this->armure;
    }

    public function setArmure(int $armure): self
    {
        $this->armure = $armure;

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

    public function getBattleField(): ?BattleField
    {
        return $this->battleField;
    }

    public function setBattleField(?BattleField $battleField): self
    {
        $this->battleField = $battleField;

        return $this;
    }

    public function getXCoordinate(): ?int
    {
        return $this->xCoordinate;
    }

    public function setXCoordinate(?int $xCoordinate): self
    {
        $this->xCoordinate = $xCoordinate;

        return $this;
    }

    public function getYCoordinate(): ?int
    {
        return $this->yCoordinate;
    }

    public function setYCoordinate(?int $yCoordinate): self
    {
        $this->yCoordinate = $yCoordinate;

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
