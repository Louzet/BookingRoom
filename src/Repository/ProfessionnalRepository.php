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

/*    public function findReservationsByEntreprisesAndStatus($entreprise_id, $status)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('rooms')
            ->join('p.rooms', 'rooms')
            ->join('rooms.reservations', 'reservations')
            ->andWhere('reservations.salle.professionnal_id = :entreprise_id')
            ->setParameter('entreprise_id', $entreprise_id)
            ->andWhere('reservations.currentStatus = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult()
            ;
    }*/

    // /**
    //  * @return Professionnal[] Returns an array of Professionnal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Professionnal
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
