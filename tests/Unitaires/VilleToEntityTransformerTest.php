<?php

namespace App\tests\Unitaires;

use App\Entity\VillesFranceFree;
use ArgumentCountError;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Exception\TransformationFailedException;

class VilleToEntityTransformerTest extends KernelTestCase
{
    private $entityManager;

    public function setUp()
    {
        $this->entityManager = self::bootKernel()->getContainer()->get('doctrine.orm.entity_manager');

        self::bootKernel($options = []);
    }

    public function test_transform_ville_into_string()
    {
        $container = self::$container;

        $villeTransformer = $container->get('ville.transformer');

        $ville = new VillesFranceFree();

        $ville->setVilleNomReel('Rio');

        $this->assertInstanceOf(VillesFranceFree::class, $ville);

        $this->assertEquals('Rio', $villeTransformer->transform($ville));
    }

    public function test_transform_ville_if_value_is_null()
    {
        $container = self::$container;

        $villeTransformer = $container->get('ville.transformer');

        $this->assertEquals('', $villeTransformer->transform(null));
    }

    public function test_reverse_transform_without_ville_argument()
    {
        $container = self::$container;

        $villeTransformer = $container->get('ville.transformer');

        $this->expectException(ArgumentCountError::class);

        $villeTransformer->reverseTransform();
    }

    public function test_reverse_transform_with_ville_equals_null()
    {
        $container = self::$container;

        $villeTransformer = $container->get('ville.transformer');

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $villeRepository = $entityManager->getRepository(VillesFranceFree::class);

        $villeNomReel = $villeRepository->findOneBy(['ville_nom_reel' => 'tokyo']);

        $this->expectException(TransformationFailedException::class);

        $villeTransformer->reverseTransform('tokyo');
    }

    public function test_reverse_transform_with_ville_exists()
    {
        $container = self::$container;

        $villeTransformer = $container->get('ville.transformer');

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $villeRepository = $entityManager->getRepository(VillesFranceFree::class);

        $villeNomReel = $villeRepository->findOneBy(['ville_nom_reel' => 'paris']);

        $this->assertInstanceOf(VillesFranceFree::class, $villeTransformer->reverseTransform('paris'));

        $this->assertEquals($villeNomReel, $villeTransformer->reverseTransform('paris'));

    }
}
