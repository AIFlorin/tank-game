<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 01.10.2018
 * Time: 20:59
 */

namespace App\Entity\Interfaces;

interface PositionInterface
{
    public function getXCoordinate(): ?int;
    public function setXCoordinate(int $coordinate);
    public function getYCoordinate(): ?int;
    public function setYCoordinate(int $coordinate);
    public function getHasObstacle(): ?bool;
    public function setHasObstacle(bool $hasObstacle);
}