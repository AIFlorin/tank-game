<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 01.10.2018
 * Time: 20:39
 */

namespace App\Services\Interfaces;

use App\Entity\BattleField;
use App\Entity\BoardPosition;
use App\Entity\GameAction;
use App\Entity\GameScore;
use App\Entity\User;

interface GameScoreManagerInterface
{
    public function createGameScore(User $user, BattleField $battleField): GameScore;
    public function addBattleFieldAction(
        GameScore $gameScore,
        BoardPosition $position,
        string $action,
        int $damage = 0
    ): GameAction;
}