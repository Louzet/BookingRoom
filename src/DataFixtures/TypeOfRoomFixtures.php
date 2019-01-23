<?php

namespace App\DataFixtures;

use App\Entity\TypeOfRoom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeOfRoomFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $typeOfRoom = new TypeOfRoom();

        $typeOfRoom->setTitle('LDAP');

        $manager->persist($typeOfRoom);

        $manager->flush();
    }
}
