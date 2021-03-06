<?php

namespace App\Repository;

use App\Entity\Facturation;
use App\Entity\LigneFacturation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneFacturation|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneFacturation|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneFacturation[]    findAll()
 * @method LigneFacturation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneFacturationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneFacturation::class);
    }

    public function resetAutoIncrement() {
        $tableName =$this->getClassMetadata()->getTableName();
        $connection = $this->getEntityManager()->getConnection();
        $connection->executeStatement("ALTER TABLE " . $tableName . " AUTO_INCREMENT = 1;");

    }

    public function findLastFacture() {
        return $this->createQueryBuilder('lf')
        ->orderBy('f.id',"desc")
        ->join(Facturation::class,"f")
        ->where("lf.Facture = f")
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();
    }


    // /**
    //  * @return LigneFacturation[] Returns an array of LigneFacturation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneFacturation
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
