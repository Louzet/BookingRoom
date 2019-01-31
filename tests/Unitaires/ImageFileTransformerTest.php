<?php

namespace App\Tests\Unitaires;

use App\Entity\Image;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\File;

class ImageFileTransformerTest extends KernelTestCase
{
    private $entityManager;

    public function setUp()
    {
        $this->entityManager = self::bootKernel()->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function test_file_image_transformed_into_string(): void
    {
        self::bootKernel($options = []);

        $container = self::$container;

        $imageFileTransformer = $container->get('image.transformer');

        $imageMock = $this->getMockBuilder(Image::class)
            ->getMock()
            ;

        $imageMock->setName('myNameIs');
        $imageMock->setFile(new File('public/image_room_directory/e3970223d8df3d864ff4eaf26dc74f0acf21b6a4.jpeg'));
        $imageMock->setPath('/home/mickael/dev/BookingRoom/public/image_room_directory');

        $this->assertInstanceOf(Image::class, $imageMock);
        $this->assertInternalType('string', $imageFileTransformer->transform($imageMock->getFile()));
    }

    public function test_transform_return_empty_string_if_file_not_exist(): void
    {
        self::bootKernel($options = []);

        $container = self::$container;

        $imageFileTransformer = $container->get('image.transformer');

        $this->assertInternalType('string', $imageFileTransformer->transform(null));
    }

    public function test_image_name_transformer_into_image_file(): void
    {
        self::bootKernel($options = []);

        $container = self::$container;

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $repository = $entityManager->getRepository(Image::class);

        $image = $repository->findOneBy(['name' => 'Booking5c4b3de11bf1b2.01662015']);

        $imageFileTransformer = $container->get('image.transformer');

        $this->assertInternalType('object', $imageFileTransformer->reverseTransform($image->getPath()));
    }

    public function test_transform_return_path()
    {
        self::bootKernel($options = []);

        $container = self::$container;

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $repository = $entityManager->getRepository(Image::class);

        $imageMock = $this->getMockBuilder(Image::class)
            ->getMock()
        ;
        $imageMock->expects($this->any())
            ->method('getPath')
            ->willReturn('/home/mickael/dev/BookingRoom/public/image_room_directory')
            ;

        $imageFileTransformer = $container->get('image.transformer');

        $getPath = $imageFileTransformer->transform($imageMock);

        $this->assertEquals('/home/mickael/dev/BookingRoom/public/image_room_directory', $getPath);
    }

    public function test_transform_if_not_instance_of_file()
    {
        self::bootKernel($options = []);

        $container = self::$container;

        $imageFileTransformer = $container->get('image.transformer');

        $this->assertSame('', $imageFileTransformer->transform(new User()));
    }

    public function test_transform_reverse_without_value()
    {
        self::bootKernel($options = []);

        $container = self::$container;

        $imageFileTransformer = $container->get('image.transformer');

        $this->expectException(TransformationFailedException::class);

        $imageFileTransformer->reverseTransform(56);
    }
}
