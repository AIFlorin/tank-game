<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 07.10.2018
 * Time: 18:46
 */

namespace App\Services\BattleActions;

use App\Entity\BattleField;
use App\Entity\BoardPosition;
use App\Entity\GameAction;
use App\Entity\User;
use App\Services\BattleActions\Abstracts\AbstractBattleAction;
use App\Services\BattleActions\Interfaces\BattleActionInterface;
use App\Services\Interfaces\BattleFieldRouterInterface;
use Doctrine\ORM\EntityManagerInterface;

class MoveTankOnBoard extends AbstractBattleAction implements BattleActionInterface
{
    const PRIORITY = 3;
    const NAME = 'Tank moved at position %s';

    /** @var BattleFieldRouterInterface */
    private $battleFiledRouter;
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        BattleFieldRouterInterface $battleFieldRouter
    ) {
        $this->entityManager = $entityManager;
        $this->battleFiledRouter = $battleFieldRouter;
    }

    public function handle(User $user, BattleField $battleField): GameAction
    {
        $boardPositions = $battleField->getBoardPositions();
        $battleFieldTanks = $battleField->getBattleFieldTank();
        $enemyTank = $this->getEnemyTank($battleFieldTanks, $user);
        $enemyTankPosition = $this->getTankBoardPosition($boardPositions, $enemyTank);
        $currentUserTank = $this->getCurrentUserTank($battleFieldTanks, $enemyTank);
        $currentUserTankPosition = $this->getTankBoardPosition($boardPositions, $currentUserTank);
        $newPosition = $this->battleFiledRouter->getNextBattlePosition(
            $boardPositions,
            $enemyTankPosition,
            $currentUserTankPosition
        );

        $gameScore = $this->getUserGameScore($user, $battleField);

        $gameAction = new GameAction();
        $gameAction->setMove($newPosition);
        $gameAction->setDamage(0);
        $gameAction->setGameScore($gameScore);
        $gameAction->setName($this->getName($newPosition));
        $gameScore->addAction($gameAction);

        $currentUserTank->setXCoordinate($newPosition->getXCoordinate());
        $currentUserTank->setYCoordinate($newPosition->getYCoordinate());

        $this->entityManager->persist($currentUserTank);
        $this->entityManager->persist($gameAction);

        return $gameAction;
    }

    public function support(User $user, BattleField $battleField): bool
    {
        return true;
    }

    public function getPriority(): int
    {
        return static::PRIORITY;
    }

    public function getName(BoardPosition $position = null): string
    {
        if (!$position) {
            return static::NAME;
        }

        return sprintf(static::NAME, sprintf('%dx%d', $position->getXCoordinate(), $position->getYCoordinate()));
    }
}
