<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 30.09.2018
 * Time: 17:17
 */

namespace App\DataFixtures;

use App\Entity\Board;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BoardFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $board = new Board();
        $board->setSize(5);
        $board->setObstacles(4);

        $this->setReference('board', $board);

        $manager->persist($board);
        $manager->flush();
    }
}