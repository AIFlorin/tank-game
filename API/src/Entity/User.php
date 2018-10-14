<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
     * @ORM\OneToMany(targetEntity="App\Entity\GameScore", mappedBy="user")
     */
    private $gameScore;

    public function __construct()
    {
        $this->gameScore = new ArrayCollection();
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

    /**
     * @return Collection|GameScore[]
     */
    public function getGameScore(): Collection
    {
        return $this->gameScore;
    }

    public function addGameScore(GameScore $gameScore): self
    {
        if (!$this->gameScore->contains($gameScore)) {
            $this->gameScore[] = $gameScore;
            $gameScore->setUser($this);
        }

        return $this;
    }

    public function removeGameScore(GameScore $gameScore): self
    {
        if ($this->gameScore->contains($gameScore)) {
            $this->gameScore->removeElement($gameScore);
            // set the owning side to null (unless already changed)
            if ($gameScore->getUser() === $this) {
                $gameScore->setUser(null);
            }
        }

        return $this;
    }
}
