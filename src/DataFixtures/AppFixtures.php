<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\TypeOfRoom;
use App\Entity\VillesFranceFree;
use App\Traits\TransliteratorSlugTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    use TransliteratorSlugTrait;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        /*$ville = new VillesFranceFree();

        for ($i = 0; $i < 40; ++$i) {
            $room = new Room();
            $room->setName($faker->sentence(random_int(2, 5)));
            $room->setSlug($this->slugify($room->getName()));
            $room->setPriceLocation($faker->numberBetween(19, 200));
            $room->setPlaceCapacity($faker->numberBetween(10, 300));
            $room->setAddress($faker->streetAddress);
            $room->setPostalCode($faker->postcode);
            $room->setDisponible($faker->randomElement([true, false]));
            $room->setType(new TypeOfRoom());
            $room->setDateCreation($faker->dateTimeBetween('- 1 year'));
            /*$room->setVille((new VillesFranceFree())->setVilleId(random_int(1, 36830)));
            $room->setVille($faker->city);*/

            /*$manager->persist($room);*/

    }
}
