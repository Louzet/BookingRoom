<?php

namespace App\Repository;

use App\Entity\Room;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Room::class);
    }

    public function findAvailableRooms()
    {
        return $this->getDisponibleRooms()
            ->getQuery()
            ->getResult();
    }

    public function findRoomsByParams(Search $search)
    {
        $query = $this->getDisponibleRooms();

        if ($search->getEvenement()) {
            $query = $query
                ->andWhere('r.type = :evenement')
                ->setParameter(':evenement', $search->getEvenement());
        }

        if ($search->getPlace()) {
            $query = $query
                ->andWhere('r.ville = :place')
                ->setParameter(':place', $search->getPlace());
        }

        return $query->getQuery()->getResult();
    }

    private function getDisponibleRooms()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.disponible = :disponible')
            ->setParameter(':disponible', 1)
            ;
    }

    // /**
    //  * @return Room[] Returns an array of Room objects
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
    public function findOneBySomeField($value): ?Room
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
