<?php

namespace App\Repository;

use App\Entity\Facturation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facturation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facturation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facturation[]    findAll()
 * @method Facturation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facturation::class);
    }

    public function resetAutoIncrement() {
        $tableName =$this->getClassMetadata()->getTableName();
        $connection = $this->getEntityManager()->getConnection();
        $connection->executeStatement("ALTER TABLE " . $tableName . " AUTO_INCREMENT = 1;");

    }


    public function findLastFacture() {
        return $this->createQueryBuilder('f')
        ->orderBy('f.id',"desc")
        ->setMaxResults(1)
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Facturation[] Returns an array of Facturation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Facturation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
