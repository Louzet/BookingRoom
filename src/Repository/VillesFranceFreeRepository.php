<?php

namespace App\Repository;

use App\Entity\VillesFranceFree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VillesFranceFree|null find($id, $lockMode = null, $lockVersion = null)
 * @method VillesFranceFree|null findOneBy(array $criteria, array $orderBy = null)
 * @method VillesFranceFree[]    findAll()
 * @method VillesFranceFree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VillesFranceFreeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VillesFranceFree::class);
    }

    public function findVillesByName($ville)
    {
        return $this->createQueryBuilder('v')
            ->addSelect('v.ville_nom_reel')
            ->where('v.ville_nom_reel LIKE :ville')
            ->setParameter(':ville', '%'.$ville.'%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return VillesFranceFree[] Returns an array of VillesFranceFree objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VillesFranceFree
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
