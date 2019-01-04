<?php

namespace App\DataFixtures;


use App\Entity\User;

class AppFixtures
{
    public function load()
    {
        $user = new User();
        for ($i=0; $i<20; $i++){
            $faker = \Faker\Factory::create('fr_FR');

        }


    }
}
