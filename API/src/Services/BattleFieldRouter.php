<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 13.10.2018
 * Time: 12:51
 */

namespace App\Services;

use App\Entity\BoardPosition;
use App\Services\Interfaces\BattleFieldRouterInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class BattleFieldRouter implements BattleFieldRouterInterface
{
    public function getNextBattlePosition(
        Collection $boardPositions,
        BoardPosition $enemyPosition,
        BoardPosition $currentPosition
    ): BoardPosition {
        $enemyPossibleMoves = $this->getXYLinePossibleMoves($boardPositions, $enemyPosition);
        $currentPossibleMoves = $this->getXYLinePossibleMoves($boardPositions, $currentPosition);

        $enemyLineIntersection = $this->getLineIntersection(
            $enemyPossibleMoves,
            $currentPossibleMoves
        );

        if ($enemyLineIntersection) {
            return $enemyLineIntersection;
        }

        return $this->getNextGoodMove($boardPositions, $currentPosition);
    }

    public function isStraightLine(
        Collection $boardPositions,
        BoardPosition $enemyPosition,
        BoardPosition $currentPosition
    ): bool {
        $straightLinePositions = $this->getStraightLinesPositions($boardPositions, $currentPosition);
        /** @var BoardPosition $linePosition */
        foreach ($straightLinePositions as $linePosition) {
            if (!$linePosition->getHasObstacle() && $linePosition === $enemyPosition) {
                return true;
            }
        }

        return false;
    }

    public function getLineIntersection(
        Collection $enemyPossibleMoves,
        Collection $currentPossibleMoves
    ): ?BoardPosition {
        /** @var BoardPosition $enemyPossibleMove */
        foreach ($enemyPossibleMoves as $enemyPossibleMove) {
            if ($currentPossibleMoves->contains($enemyPossibleMove)) {
                return $enemyPossibleMove;
            }
        }

        return null;
    }

    public function getNextGoodMove(Collection $boardPositions, BoardPosition $currentPosition): BoardPosition
    {
        $xLineMappedByYCoordinate = $this->mapByYCoordinate(
            $this->getXLinePositions($boardPositions, $currentPosition)
        )->toArray();

        $possibleXLineMove = $this->getLinePossibleMove($xLineMappedByYCoordinate);

        if ($possibleXLineMove) {
            return $possibleXLineMove;
        }

        $yLineMappedByXCoordinate = $this->mapByXCoordinate(
            $this->getYLinePositions($boardPositions, $currentPosition)
        )->toArray();

        $possibleYLineMove = $this->getLinePossibleMove($yLineMappedByXCoordinate);

        if ($possibleYLineMove) {
            return $possibleYLineMove;
        }

        throw new \LogicException('Tank must be blocked.');
    }

    public function getXYLinePossibleMoves(Collection $boardPositions, BoardPosition $boardPosition): Collection
    {
        $xLineMappedByYCoordinate = $this->mapByYCoordinate(
            $this->getXLinePositions($boardPositions, $boardPosition)
        )->toArray();

        $xLinePossibleMoves = $this->getLinePossibleMovesUntilObstacle($xLineMappedByYCoordinate);

        $yLineMappedByXCoordinate = $this->mapByXCoordinate(
            $this->getYLinePositions($boardPositions, $boardPosition)
        )->toArray();

        $yLinePossibleMoves = $this->getLinePossibleMovesUntilObstacle($yLineMappedByXCoordinate);

        return new ArrayCollection(array_merge($xLinePossibleMoves->toArray(), $yLinePossibleMoves->toArray()));
    }

    public function getLinePossibleMove(array $boardPositions): ?BoardPosition
    {
        sort($boardPositions);
        $possibleMove = new ArrayCollection();

        /** @var BoardPosition $linePosition */
        foreach ($boardPositions as $linePosition) {
            if ($linePosition->getHasObstacle()) {
                break;
            }
            $possibleMove->add($linePosition);
        }

        return ($possibleMove->last()) ? : null;
    }

    public function getLinePossibleMovesUntilObstacle(array $boardPositions): Collection
    {
        sort($boardPositions);
        $possibleMove = new ArrayCollection();

        /** @var BoardPosition $linePosition */
        foreach ($boardPositions as $linePosition) {
            if ($linePosition->getHasObstacle()) {
                break;
            }
            $possibleMove->add($linePosition);
        }

        return $possibleMove;
    }

    public function mapByXCoordinate(Collection $boardPositions): Collection
    {
        $map = new ArrayCollection();
        /** @var BoardPosition $boardPosition */
        foreach ($boardPositions as $boardPosition) {
            $map->set($boardPosition->getXCoordinate(), $boardPosition);
        }

        return $map;
    }

    public function mapByYCoordinate(Collection $boardPositions): Collection
    {
        $map = new ArrayCollection();
        /** @var BoardPosition $boardPosition */
        foreach ($boardPositions as $boardPosition) {
            $map->set($boardPosition->getYCoordinate(), $boardPosition);
        }

        return $map;
    }

    public function getStraightLinesPositions(Collection $boardPositions, BoardPosition $currentPosition): array
    {
        $linePositions = array_merge(
            $this->getXLinePositions($boardPositions, $currentPosition)->toArray(),
            $this->getYLinePositions($boardPositions, $currentPosition)->toArray()
        );

        return $linePositions;
    }

    public function getYLinePositions(Collection $boardPositions, BoardPosition $currentPosition): Collection
    {
        $yCoordinate = $currentPosition->getYCoordinate();

        $yLinePositions = new ArrayCollection();
        /** @var BoardPosition $position */
        foreach ($boardPositions as $position) {
            if ($position === $currentPosition) {
                continue;
            }

            if ($position->getYCoordinate() == $yCoordinate) {
                $yLinePositions->add($position);
            }
        }

        return $yLinePositions;
    }

    public function getXLinePositions(Collection $boardPositions, BoardPosition $currentPosition): Collection
    {
        $xCoordinate = $currentPosition->getXCoordinate();

        $xLinePositions = new ArrayCollection();
        /** @var BoardPosition $position */
        foreach ($boardPositions as $position) {
            if ($position === $currentPosition) {
                continue;
            }

            if ($position->getXCoordinate() == $xCoordinate) {
                $xLinePositions->add($position);
            }
        }

        return $xLinePositions;
    }
}
