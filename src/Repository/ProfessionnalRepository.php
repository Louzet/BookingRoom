<?php

namespace App\Repository;

use App\Entity\Professionnal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Professionnal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professionnal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professionnal[]    findAll()
 * @method Professionnal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionnalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Professionnal::class);
    }
}