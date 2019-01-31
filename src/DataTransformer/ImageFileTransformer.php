<?php

namespace App\DataTransformer;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ImageFileTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * imageFileTransformer constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed|Image $value
     *
     * @return string|null
     */
    public function transform($value): ?string
    {
        if (null === $value) {
            return '';
        }
        if (!$value instanceof Image) {
            return false;
        }
        return $value->getPath();
    }

    /**
     * @param mixed $value
     *
     * @return object|null
     */
    public function reverseTransform($value): ?object
    {
        $image = $this->entityManager
            ->getRepository(Image::class)
            ->findOneBy(['path' => $value])
            ;
        if (!is_string($value)) {

            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $value
            ));
        }

        return $image;
    }
}
