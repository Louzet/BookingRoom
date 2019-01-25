<?php

namespace App\DataTransformer;

use App\Entity\VillesFranceFree;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class villeToEntityTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (ville) to a string (ville).
     *
     * @param VillesFranceFree|null $ville
     *
     * @return string
     */
    public function transform($ville)
    {
        if (null === $ville) {
            return '';
        }
        return $ville->getVilleNomReel();
    }

    /**
     * Transforms a string (ville) to an object (VillesFranceFree).
     *
     * @param string $villeEntity
     *
     * @return VillesFranceFree|null
     *
     * @throws TransformationFailedException if object (ville) is not found
     */
    public function reverseTransform($villeEntity)
    {
        // no issue number? It's optional, so that's ok
        if (!$villeEntity) {
            return;
        }

        $ville = $this->entityManager
            ->getRepository(VillesFranceFree::class)
            // query for the issue with this id
            ->findOneBy(['ville_nom_reel' => $villeEntity])
        ;

        if (null === $ville) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $villeEntity
            ));
        }

        return $ville;
    }
}
