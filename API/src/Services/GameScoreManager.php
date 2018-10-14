<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 01.10.2018
 * Time: 20:33
 */

namespace App\Services;

use App\Entity\BattleField;
use App\Entity\BoardPosition;
use App\Entity\GameAction;
use App\Entity\GameScore;
use App\Entity\User;
use App\Services\Interfaces\GameScoreManagerInterface;

class GameScoreManager implements GameScoreManagerInterface
{
    public function createGameScore(User $user, BattleField $battleField): GameScore
    {
        $gameScore = new GameScore();
        $gameScore->setUser($user);
        $gameScore->setBattleField($battleField);
        $gameScore->setIsWon(false);

        return $gameScore;
    }

    public function addBattleFieldAction(
        GameScore $gameScore,
        BoardPosition $position,
        string $action,
        int $damage = 0
    ): GameAction {
        $gameAction = new GameAction();
        $gameAction->setDamage($damage);
        $gameAction->setName($action);
        $gameAction->setGameScore($gameScore);
        $gameAction->setMove($position);
        $gameScore->addAction($gameAction);

        return $gameAction;
    }
}
