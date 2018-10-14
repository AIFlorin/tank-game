<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 01.10.2018
 * Time: 20:25
 */

namespace App\Services;

use App\Entity\BattleField;
use App\Entity\Board;
use App\Entity\BoardPosition;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Interfaces\BattleFieldCreatorInterface;
use App\Services\Interfaces\GameScoreManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class BattleFieldCreator implements BattleFieldCreatorInterface
{
    const USERS_ON_BOARD = 2;

    private $gameScoreManager;
    private $userRepository;

    /**
     * BattleFieldCreatorAction constructor.
     * @param GameScoreManagerInterface $gameScoreCreator
     * @param UserRepository $userRepository
     */
    public function __construct(GameScoreManagerInterface $gameScoreCreator, UserRepository $userRepository)
    {
        $this->gameScoreManager = $gameScoreCreator;
        $this->userRepository = $userRepository;
    }

    public function generateBattleField(Board $board): BattleField
    {
        $battleField = new BattleField();
        $battleField->setBoard($board);

        foreach ($this->getBattleFieldUsers() as $user) {
            $battleField->addPlayingUser($user);
            $gameScore = $this->gameScoreManager->createGameScore($user, $battleField);
            $battleField->addGameScore($gameScore);
        }

        foreach ($this->getBoardPositions($board) as $boardPosition) {
            $battleField->addBoardPosition($boardPosition);
        }

        return $battleField;
    }

    /**
     * @param int $usersNumber
     * @return Collection|User[]
     */
    public function getBattleFieldUsers(int $usersNumber = self::USERS_ON_BOARD): array
    {
        return $this->userRepository->getBattleFieldUsers($usersNumber);
    }

    /**
     * @param Board $board
     * @return Collection|BoardPosition[]
     */
    public function getBoardPositions(Board $board): Collection
    {
        $boardSize = $board->getSize();
        $boardPoints = $boardSize * $boardSize;
        $boardObstacles = $board->getObstacles();
        $plainBoard = $this->generatePlainBoard($board);

        do {
            $boardId = mt_rand(0, $boardPoints - 1);
            /** @var BoardPosition $point */
            if ($plainBoard->containsKey($boardId) &&
                $plainBoard->get($boardId)->getHasObstacle()) {
                continue;
            }

            /** @var BoardPosition $boardPosition */
            $boardPosition = $plainBoard->get($boardId);
            $boardPosition->setHasObstacle(true);

            --$boardObstacles;
        } while ($boardObstacles > 0);

        return $plainBoard;
    }

    /**
     * @param Board $board
     * @return Collection|BoardPosition[]
     */
    public function generatePlainBoard(Board $board): Collection
    {
        $boardSize = $board->getSize();
        $boardPoints = $boardSize * $boardSize;
        $boardWithNoObstacle = new ArrayCollection();

        for ($i = 1; $i <= $boardPoints; $i++) {
            $boardPosition = new BoardPosition();
            $boardPosition->setBoard($board);
            $boardPosition->setXCoordinate($this->getBoardXCoordinate($i, $boardSize));
            $boardPosition->setYCoordinate($this->getBoardYCoordinate($i, $boardSize));
            $boardPosition->setHasObstacle(false);
            $boardWithNoObstacle->add($boardPosition);
        }

        return $boardWithNoObstacle;
    }

    public function getBoardXCoordinate(int $blockId, int $boardSize): int
    {
        $coordinate = $blockId % $boardSize;

        if ($coordinate) {
            return $coordinate;
        }

        return $boardSize;
    }

    public function getBoardYCoordinate(int $blockId, int $boardSize): int
    {
        return ceil($blockId / $boardSize);
    }
}
