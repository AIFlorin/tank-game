<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 07.10.2018
 * Time: 13:27
 */

namespace App\Services;

use App\Entity\BattleField;
use App\Entity\GameAction;
use App\Entity\User;
use App\Services\BattleActions\Interfaces\BattleActionInterface;
use App\Services\Interfaces\BattleManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;

class BattleManager implements BattleManagerInterface
{
    /** @var iterable */
    private $battleActions;
    /** @var Collection|BattleActionInterface[] */
    private $battleActionsByPriority;

    /**
     * BattleManager constructor.
     * @param iterable $battleActions
     */
    public function __construct(iterable $battleActions)
    {
        $this->battleActions = $battleActions;
        $this->orderBattleActionsByPriority();
    }

    public function makeTurn(BattleField $battleField): GameAction
    {
        $nextPlayerTurn = $this->getPlayerTurn($battleField);
        $orderedPriorities = array_keys($this->orderBattleActionsByPriority()->toArray());
        sort($orderedPriorities);
        foreach ($orderedPriorities as $key) {
            /** @var BattleActionInterface $battleAction */
            $battleAction = $this->orderBattleActionsByPriority()->get($key);
            if ($battleAction->support($nextPlayerTurn, $battleField)) {
                return $battleAction->handle($nextPlayerTurn, $battleField);
            }
        }

        throw new ForbiddenOverwriteException('Battle has ended.');
    }

    public function getPlayerTurn(BattleField $battleField): User
    {
        $gameScoreCollection = $battleField->getGameScores();
        $playerTurns = new ArrayCollection();
        $playerIdToUser = new ArrayCollection();

        foreach ($gameScoreCollection as $gameScore) {
            $gameScoreUser = $gameScore->getUser();
            $playerTurns->set($gameScoreUser->getId(), $gameScore->getActions()->count());
            $playerIdToUser->set($gameScoreUser->getId(), $gameScoreUser);
        }

        $userId = array_search(min($playerTurns->toArray()), $playerTurns->toArray());
        $user = $playerIdToUser->get($userId);

        return $user;
    }

    public function orderBattleActionsByPriority(): Collection
    {
        $this->battleActionsByPriority = new ArrayCollection();
        /** @var BattleActionInterface $action */
        foreach ($this->battleActions as $action) {
            $this->checkForDuplicatePriority($action);
            $this->battleActionsByPriority->set($action->getPriority(), $action);
        }

        return $this->battleActionsByPriority;
    }

    /**
     * @param BattleActionInterface $action
     * @throws ForbiddenOverwriteException
     * @return void
     */
    public function checkForDuplicatePriority(BattleActionInterface $action): void
    {
        if (in_array($action->getPriority(), $this->battleActionsByPriority->getKeys())) {
            throw new ForbiddenOverwriteException(sprintf(
                "There are two actions %s with the same priority: %d",
                implode(', ', [$action->getName(), $this->battleActionsByPriority->get($action->getPriority())]),
                $action->getPriority()
            ));
        }
    }
}
