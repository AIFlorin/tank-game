<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 13.10.2018
 * Time: 14:02
 */

namespace App\Services\BattleActions\Abstracts;

use App\Entity\BattleField;
use App\Entity\BattleFieldTank;
use App\Entity\BoardPosition;
use App\Entity\GameScore;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;

abstract class AbstractBattleAction
{
    public function getUserGameScore(User $user, BattleField $battleField): GameScore
    {
        $gameScores = $battleField->getGameScores();

        foreach ($gameScores as $gameScore) {
            if ($gameScore->getUser() === $user) {
                return $gameScore;
            }
        }

        throw new \LogicException("GameScore has not been found for the provided user.");
    }

    public function getTankBoardPosition(Collection $boardPositions, BattleFieldTank $tank): BoardPosition
    {
        $tankXPosition = $tank->getXCoordinate();
        $tankYPosition = $tank->getYCoordinate();
        /** @var BoardPosition $position */
        foreach ($boardPositions as $position) {
            if ($position->getXCoordinate() == $tankXPosition && $position->getYCoordinate() == $tankYPosition) {
                return $position;
            }
        }

        throw new \LogicException("Tank is not on the board.");
    }

    public function getEnemyTank(Collection $battleFieldTanks, User $currentUser): BattleFieldTank
    {
        /** @var BattleFieldTank $tank */
        foreach ($battleFieldTanks as $tank) {
            if ($tank->getUser() !== $currentUser) {
                return $tank;
            }
        }

        throw new \LogicException('There is only the current user tank on the board.');
    }

    public function getCurrentUserTank(Collection $battleFieldTanks, BattleFieldTank $enemyTank): BattleFieldTank
    {
        /** @var BattleFieldTank $tank */
        foreach ($battleFieldTanks as $tank) {
            if ($tank !== $enemyTank) {
                return $tank;
            }
        }

        throw new \LogicException('There is only the current user tank on the board.');
    }
}
