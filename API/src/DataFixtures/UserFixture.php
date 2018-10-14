<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 30.09.2018
 * Time: 17:11
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $userOne = $this->createUser('user_one');
        $this->setReference('user_one', $userOne);
        $manager->persist($userOne);
        $userTwo = $this->createUser('user_two');
        $this->setReference('user_one', $userOne);
        $manager->persist($userTwo);
        $manager->flush();
    }

    public function createUser(string $name)
    {
        $user = new User();
        $user->setName($name);

        return $user;
    }
}