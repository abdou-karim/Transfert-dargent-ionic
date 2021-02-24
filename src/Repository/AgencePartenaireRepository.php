<?php

namespace App\Repository;

use App\Entity\AgencePartenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AgencePartenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgencePartenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgencePartenaire[]    findAll()
 * @method AgencePartenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgencePartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgencePartenaire::class);
    }

    // /**
    //  * @return AgencePartenaire[] Returns an array of AgencePartenaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AgencePartenaire
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
