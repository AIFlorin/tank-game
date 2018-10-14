<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 13.10.2018
 * Time: 12:51
 */

namespace App\Services\Interfaces;

use App\Entity\BoardPosition;
use Doctrine\Common\Collections\Collection;

interface BattleFieldRouterInterface
{
    public function isStraightLine(
        Collection $boardPositions,
        BoardPosition $enemyPosition,
        BoardPosition $currentPosition
    ): bool;
    public function getNextBattlePosition(
        Collection $boardPositions,
        BoardPosition $enemyPosition,
        BoardPosition $currentPosition
    ): BoardPosition;
}
