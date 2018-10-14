<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 07.10.2018
 * Time: 22:11
 */

namespace App\Controller;

use App\Entity\BattleField;
use App\Services\Interfaces\BattleManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class BattleFieldSimulatorAction
{
    private $entityManager;
    private $battleManager;
    private $serializer;

    /**
     * BattleFieldSimulatorAction constructor.
     * @param EntityManagerInterface $entityManager
     * @param BattleManagerInterface $battleManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        BattleManagerInterface $battleManager,
        SerializerInterface $serializer
    ) {
        $this->entityManager = $entityManager;
        $this->battleManager = $battleManager;
        $this->serializer = $serializer;
    }

    public function __invoke(BattleField $data)
    {
        if ($this->isBattleWon($data)) {
            throw new \LogicException("Battle is already won!");
        }

        $this->battleManager->makeTurn($data);
        $this->entityManager->flush();

        $gameScores = $data->getGameScores();

        $response = new ArrayCollection();
        foreach ($gameScores as $gameScore) {
            $userName = $gameScore->getUser()->getName();
            $response->set('User'. $userName, $gameScore->getActions());
            $response->set(sprintf('User %s GameScore', $userName), $gameScore);
        }

        return new Response($this->serializer->serialize($response, 'json'));
    }

    public function isBattleWon(BattleField $battleField): bool
    {
        $gameScoreCollection = $battleField->getGameScores();

        foreach ($gameScoreCollection as $gameScore) {
            if ($gameScore->getIsWon()) {
                return true;
            }
        }

        return false;
    }
}
