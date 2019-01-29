<?php
/**
 * Created by PhpStorm.
 * User: mickael
 * Date: 25/01/19
 * Time: 19:23.
 */

namespace App\DataTransformer;

use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class imageFileTransformer implements DataTransformerInterface
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
     * @param mixed $value
     * @return string|null
     */
    public function transform($value): ?string
    {
        if (null === $value) {
            return '';
        }

        return $value->getPath();
    }

    /**
     * @param mixed $value
     * @return ImageRepository|mixed|object|void|null
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return;
        }

        $image = $this->entityManager
            ->getRepository(ImageRepository::class)
            ->findOneBy(['path' => $value])
            ;

        if (null === $image) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $value
            ));
        }

        return $image;
    }
}
