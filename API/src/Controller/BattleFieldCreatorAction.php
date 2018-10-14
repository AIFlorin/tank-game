<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 07.10.2018
 * Time: 11:49
 */

namespace App\Controller;

use App\Entity\BattleField;
use App\Repository\BoardRepository;
use App\Services\Interfaces\BattleFieldCreatorInterface;

class BattleFieldCreatorAction
{
    /** @var BattleFieldCreatorInterface */
    private $battleFieldCreator;
    /** @var BoardRepository */
    private $boardRepository;

    /**
     * BattleFieldCreatorAction constructor.
     * @param BattleFieldCreatorInterface $battleFieldCreator
     * @param BoardRepository $boardRepository
     */
    public function __construct(BattleFieldCreatorInterface $battleFieldCreator, BoardRepository $boardRepository)
    {
        $this->battleFieldCreator = $battleFieldCreator;
        $this->boardRepository = $boardRepository;
    }

    public function __invoke(): BattleField
    {
        $board = $this->boardRepository->find(1);
        $battleField = $this->battleFieldCreator->generateBattleField($board);

        return $battleField;
    }
}
