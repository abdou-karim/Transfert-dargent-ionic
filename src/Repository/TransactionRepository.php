<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    // /**
    //  * @return Transaction[] Returns an array of Transaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transaction
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getCommissionAgencePartenaire($idAgence){
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->join('t.user','u')
            ->join('u.agencePartenaire','a')
            ->where('a.id=:idagence')
            ->setParameter('idagence',$idAgence)
            ->getQuery()
            ->getResult();
        return $query;
    }
    public function getCommissionUserAgence($idUser)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.user','u')
            ->where('u.id=:idUser')
            ->setParameter('idUser',$idUser)
            ->getQuery()
            ->getResult();
        return $query;
    }
    public function getTransactionByPhoneNumber($numeroClient,$numeroBeneficiaire,$dateTransfert){
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->join('t.client','u')
            ->where('u.numeroClient=:numC')
            ->andWhere('u.numeroBeneficiaire=:numB')
            ->andWhere('t.dateTransfert=:dateT')
            ->setParameter('numC',$numeroClient)
            ->setParameter('numB',$numeroBeneficiaire)
            ->setParameter('dateT',$dateTransfert)
            ->getQuery()
            ->getOneOrNullResult();
        return $query;
    }
    public function getTransactionEnCours($idUser,$statut)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.statut=:encours')
            ->join('p.user','u')
            ->andWhere('u.id=:idUser')
            ->setParameter('encours',$statut)
            ->setParameter('idUser',$idUser)
            ->getQuery()
            ->getResult();
        return $query;
    }
}
