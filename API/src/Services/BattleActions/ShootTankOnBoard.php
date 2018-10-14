<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 07.10.2018
 * Time: 18:46
 */

namespace App\Services\BattleActions;

use App\Entity\BattleField;
use App\Entity\BattleFieldTank;
use App\Entity\BoardPosition;
use App\Entity\GameAction;
use App\Entity\User;
use App\Services\BattleActions\Abstracts\AbstractBattleAction;
use App\Services\BattleActions\Interfaces\BattleActionInterface;
use App\Services\Interfaces\BattleFieldRouterInterface;
use Doctrine\ORM\EntityManagerInterface;

class ShootTankOnBoard extends AbstractBattleAction implements BattleActionInterface
{
    const PRIORITY = 2;
    const NAME = 'Shoot tank at position %s';

    /** @var BattleFieldRouterInterface */
    private $battleFieldRouter;
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var BattleFieldTank */
    private $enemyTank;
    /** @var BoardPosition */
    private $enemyTankPosition;
    /** @var BattleFieldTank */
    private $currentUserTank;
    /** @var BoardPosition */
    private $currentUserTankPosition;

    /**
     * ShootTankOnBoard constructor.
     * @param BattleFieldRouterInterface $battleFieldRouter
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(BattleFieldRouterInterface $battleFieldRouter, EntityManagerInterface $entityManager)
    {
        $this->battleFieldRouter = $battleFieldRouter;
        $this->entityManager = $entityManager;
    }

    public function handle(User $user, BattleField $battleField): GameAction
    {
        $currentTankDamage = rand(0, $this->currentUserTank->getDamage());

        $gameScore = $this->getUserGameScore($user, $battleField);

        $gameAction = new GameAction();
        $gameAction->setMove(null);
        $gameAction->setDamage($currentTankDamage);
        $gameAction->setGameScore($gameScore);
        $gameScore->addAction($gameAction);

        $remainingEnemyTankArmure = $this->getTankArmure($this->enemyTank->getArmure(), $currentTankDamage);
        $remainingEnemyTankHealth = $this->getTankHealth(
            $this->enemyTank->getHealth(),
            $remainingEnemyTankArmure,
            $currentTankDamage
        );

        if (!$currentTankDamage) {
            $gameAction->setName($this->getName($currentTankDamage));
        } else {
            $gameAction->setName(
                $this->getName($currentTankDamage, $remainingEnemyTankArmure, $remainingEnemyTankHealth)
            );
        }

        $this->enemyTank->setArmure($remainingEnemyTankArmure);
        $this->enemyTank->setHealth($remainingEnemyTankHealth);

        if (!$remainingEnemyTankHealth) {
            $gameScore->setIsWon(1);
            $this->entityManager->persist($gameScore);
        }

        $this->entityManager->persist($this->enemyTank);
        $this->entityManager->persist($gameAction);

        return $gameAction;
    }

    public function support(User $user, BattleField $battleField): bool
    {
        $battleFieldTanks = $battleField->getBattleFieldTank();
        $battleFieldPosition = $battleField->getBoardPositions();

        $this->enemyTank = $this->getEnemyTank($battleFieldTanks, $user);
        $this->enemyTankPosition = $this->getTankBoardPosition($battleFieldPosition, $this->enemyTank);
        $this->currentUserTank = $this->getCurrentUserTank($battleFieldTanks, $this->enemyTank);
        $this->currentUserTankPosition = $this->getTankBoardPosition($battleFieldPosition, $this->currentUserTank);

        return $this->battleFieldRouter
            ->isStraightLine($battleFieldPosition, $this->enemyTankPosition, $this->currentUserTankPosition);
    }

    public function getPriority(): int
    {
        return static::PRIORITY;
    }

    public function getName(int $damage = null, int $enemyArmure = null, int $enemyHealth = null): string
    {
        $shootTank = sprintf(static::NAME, sprintf(
            '%dx%d',
            $this->enemyTankPosition->getXCoordinate(),
            $this->enemyTankPosition->getYCoordinate()
        ));

        if (!$damage) {
            return $shootTank. ' and missed.';
        } else {
            return sprintf(
                $shootTank. ' and dealt damage %d resulting in armure %d and health %d.',
                $damage,
                $enemyArmure,
                $enemyHealth
            );
        }

    }

    public function getTankHealth(int $currentHealth, int $currentArmure, int $damage): int
    {
        if (!$currentArmure) {
            $remainingHealth = $currentHealth - $damage;
            return ($remainingHealth > 0) ? $remainingHealth : 0;
        }

        return $currentHealth;
    }

    public function getTankArmure(int $currentArmure, int $damage): int
    {
        if ($currentArmure) {
            $remainingArmure = $currentArmure - $damage;
            return ($remainingArmure > 0) ? $remainingArmure : 0;
        }

        return 0;
    }
}
