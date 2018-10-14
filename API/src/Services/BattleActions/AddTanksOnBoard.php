<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 07.10.2018
 * Time: 18:45
 */

namespace App\Services\BattleActions;

use App\Entity\BattleField;
use App\Entity\BattleFieldTank;
use App\Entity\BoardPosition;
use App\Entity\GameAction;
use App\Entity\Tank;
use App\Entity\User;
use App\Repository\TankRepository;
use App\Services\BattleActions\Abstracts\AbstractBattleAction;
use App\Services\BattleActions\Interfaces\BattleActionInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Exception\LogicException;

class AddTanksOnBoard extends AbstractBattleAction implements BattleActionInterface
{
    const PRIORITY = 1;
    const NAME = 'Tank had been added on board on the following location %s';
    const USERS_ON_BOARD = 2;

    /** @var TankRepository */
    private $tankRepository;
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * AddTanksOnBoard constructor.
     * @param TankRepository $tankRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(TankRepository $tankRepository, EntityManagerInterface $entityManager)
    {
        $this->tankRepository = $tankRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(User $user, BattleField $battleField): GameAction
    {
        $tankBoardPosition = $this->getTankPosition($battleField);
        $battleFieldTank = new BattleFieldTank();
        $battleFieldTank->setUser($user);
        $battleFieldTank->setXCoordinate($tankBoardPosition->getXCoordinate());
        $battleFieldTank->setYCoordinate($tankBoardPosition->getYCoordinate());
        $battleFieldTank->setBattleField($battleField);
        $userTank = $this->getUserTank($battleField);
        $battleFieldTank->setTank($userTank);
        $battleFieldTank->setDamage($userTank->getDamage());
        $battleFieldTank->setHealth($userTank->getHealth());
        $battleFieldTank->setArmure($userTank->getArmure());

        $gameScore = $this->getUserGameScore($user, $battleField);

        $gameAction = new GameAction();
        $gameAction->setDamage(0);
        $gameAction->setMove($tankBoardPosition);
        $gameAction->setGameScore($gameScore);
        $gameAction->setName($this->getName($tankBoardPosition));
        $gameScore->addAction($gameAction);

        $this->entityManager->persist($battleFieldTank);
        $this->entityManager->persist($gameAction);

        return $gameAction;
    }

    public function support(User $user, BattleField $battleField): bool
    {
        return $battleField->getBattleFieldTank()->count() < static::USERS_ON_BOARD;
    }

    public function getPriority(): int
    {
        return static::PRIORITY;
    }

    /**
     * @param BoardPosition|null $position
     * @return string
     */
    public function getName(BoardPosition $position = null): string
    {
        if (!$position) {
            return static::NAME;
        }

        return sprintf(static::NAME, sprintf('%dx%d', $position->getXCoordinate(), $position->getYCoordinate()));
    }

    public function getTankPosition(BattleField $battleField): BoardPosition
    {
        $boardPositions = $battleField->getBoardPositions();

        if ($battleField->getBattleFieldTank()->count()) {
            /** @var BattleFieldTank $firstTankPosition */
            $firstBattleFieldTank = $battleField->getBattleFieldTank()->first();
            $tankPosition = $this->getSecondTankPosition($boardPositions, $firstBattleFieldTank);
        } else {
            $tankPosition = $this->getFirstTankPosition($boardPositions);
        }

        return $tankPosition;
    }

    public function getFirstTankPosition(Collection $boardPositions): BoardPosition
    {
        foreach ($boardPositions as $boardPosition) {
            if (!$boardPosition->getHasObstacle()) {
                return $boardPosition;
            }
        }

        throw new LogicException('No free point on board for the first tank.');
    }

    public function getSecondTankPosition(
        Collection $boardPositions,
        BattleFieldTank $firstBattleFieldTank
    ): BoardPosition {
        $firstTankPosition = $this->getFirstTankBoardPosition($firstBattleFieldTank, $boardPositions);
        $reverseBoardPositions = array_reverse($boardPositions->toArray());
        dump($boardPositions, $reverseBoardPositions);

        /** @var BoardPosition $boardPosition */
        foreach ($reverseBoardPositions as $boardPosition) {
            if (!$boardPosition->getHasObstacle() && $boardPosition !== $firstTankPosition) {
                return $boardPosition;
            }
        }

        throw new LogicException('No free point on board for the second tank.');
    }

    public function getFirstTankBoardPosition(
        BattleFieldTank $battleFieldTank,
        Collection $boardPositions
    ): BoardPosition {
        /** @var BoardPosition $boardPosition */
        foreach ($boardPositions as $boardPosition) {
            if ($boardPosition->getXCoordinate() == $battleFieldTank->getXCoordinate() &&
                $boardPosition->getYCoordinate() == $battleFieldTank->getYCoordinate()) {
                return $boardPosition;
            }
        }

        throw new LogicException('First tank position cannot be found on boardPositions.');
    }

    public function getUserTank(BattleField $battleField): Tank
    {
        $battleFieldTanks = $battleField->getBattleFieldTank();
        if ($battleFieldTanks->count()) {
            /** @var BattleFieldTank $battleFieldTank */
            $battleFieldTank = $battleFieldTanks->first();
            $tank = $battleFieldTank->getTank();
            return $this->tankRepository->getOtherTank($tank);
        } else {
            return $this->tankRepository->find(1);
        }
    }
}
