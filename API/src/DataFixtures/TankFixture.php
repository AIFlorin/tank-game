<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 30.09.2018
 * Time: 17:19
 */

namespace App\DataFixtures;

use App\Entity\Tank;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TankFixture extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $panzerTank = $this->getPanzerTank();

        $this->setReference('panzer_tank', $panzerTank);
        $manager->persist($panzerTank);

        $t34Tank = $this->getT34Tank();

        $this->setReference('t34_tank', $t34Tank);
        $manager->persist($t34Tank);

        $manager->flush();
    }

    public function getPanzerTank(): Tank
    {
        return $this->createTank('Panzer', 10, 25, 15);
    }

    public function getT34Tank(): Tank
    {
        return $this->createTank('T34', 8, 20, 20);

    }

    public function createTank(string $name, int $armure, int $damage, int $health): Tank
    {
        $tank = new Tank();
        $tank->setName($name);
        $tank->setArmure($armure);
        $tank->setDamage($damage);
        $tank->setHealth($health);

        return $tank;
    }
}