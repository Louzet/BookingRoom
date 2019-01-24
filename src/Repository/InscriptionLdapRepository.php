<?php

namespace App\Repository;


use App\Entity\InscriptionLdap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InscriptionLdap|null find($id, $lockMode = null, $lockVersion = null)
 * @method InscriptionLdap|null findOneBy(array $criteria, array $orderBy = null)
 * @method InscriptionLdap[]    findAll()
 * @method InscriptionLdap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionLdapRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InscriptionLdap::class);
    }

    /**
     * Récupère les inscriptions de Ldap
     * @return mixed
     */
    public function findInscriptionLdap($id): array
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
    }

    public function findLdapByHostname($hostname){
        return $this->createQueryBuilder('c')
            ->addSelect('c.hostname')
            ->where('c.hostname = :hostname')
            ->setParameter(':hostname', $hostname)
            ->getQuery()->getResult();
    }




}
