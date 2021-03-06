<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function findAllReservationsByStatus($startDate, $endDate, $currentStatus)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.dateDebut BETWEEN :startDate and :endDate')
            ->setParameter(':startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter(':endDate', $endDate->format('Y-m-d H:i:s'))
            ->andWhere('r.currentStatus LIKE :currentStatus')
            ->setParameter(':currentStatus', "%$currentStatus%")
            ->getQuery()
            ->getResult();
    }

    public function findAllReservation($startDate, $endDate)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.dateDebut BETWEEN :startDate and :endDate')
            ->setParameter(':startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter(':endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();
    }

    public function findReservationsByStatus($userId, $status)
    {
        return $this->createQueryBuilder('r')
            ->where('r.user = :userId')
            ->setParameter(':userId', $userId)
            ->andWhere('r.currentStatus LIKE :status')
            ->setParameter(':status', "%$status%")
            ->orderBy('r.ReservedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findMyReservationsByStatus($id_entreprise, $status)
    {
        return $this->createQueryBuilder('r')
            ->join('r.salle', 'salle')
            ->join('salle.professionnal', 'entreprise')
            ->andWhere('entreprise.id = :id_entreprise')
            ->setParameter('id_entreprise', $id_entreprise)
            ->andWhere('r.currentStatus LIKE :status')
            ->setParameter('status', "%$status%")
            ->orderBy('r.ReservedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;

    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
