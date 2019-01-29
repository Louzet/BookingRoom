<?php

namespace App\DataFixtures;

use App\Entity\VillesFranceFree;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VillesFranceFreeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $villesFranceFree = new VillesFranceFree();

        $villesFranceFree->setVilleDepartement('0');
        $villesFranceFree->setVilleSlug('0');
        $villesFranceFree->setVilleNom('0');
        $villesFranceFree->setVilleNomSimple('0');
        $villesFranceFree->setVilleNomReel('0');
        $villesFranceFree->setVilleNomSoundex('0');
        $villesFranceFree->setVilleNomMetaphone('0');
        $villesFranceFree->setVilleCodePostal('0');
        $villesFranceFree->setVilleCommune(0);
        $villesFranceFree->setVilleCodeCommune('0');
        $villesFranceFree->setVilleArrondissement(0);
        $villesFranceFree->setVilleCanton('0');
        $villesFranceFree->setVilleAmdi(0);
        $villesFranceFree->setVillePopulation2010(0);
        $villesFranceFree->setVillePopulation1999(0);
        $villesFranceFree->setVillePopulation2012(0);
        $villesFranceFree->setVilleDensite2010(0);
        $villesFranceFree->setVilleSurface(0);
        $villesFranceFree->setVilleLongitudeDeg(0);
        $villesFranceFree->setVilleLatitudeDeg(0);
        $villesFranceFree->setVilleLongitudeGrd('0');
        $villesFranceFree->setVilleLatitudeGrd('0');
        $villesFranceFree->setVilleLatitudeDms('0');
        $villesFranceFree->setVilleLongitudeDms('0');
        $villesFranceFree->setVilleZmin(0);
        $villesFranceFree->setVilleZmax(0);

        $manager->persist($villesFranceFree);

        $manager->flush();
    }
}
