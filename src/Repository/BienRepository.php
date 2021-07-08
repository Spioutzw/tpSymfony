<?php

namespace App\Repository;

use App\Entity\Bien;
use App\Entity\TypeBien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bien[]    findAll()
 * @method Bien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bien::class);
    }


    public function resetAutoIncrement() {
        $tableName =$this->getClassMetadata()->getTableName();
        $connection = $this->getEntityManager()->getConnection();
        $connection->executeStatement("ALTER TABLE " . $tableName . " AUTO_INCREMENT = 1;");

    }

    public function selectById() {
        $entityManager = $this->getEntityManager();

         return $entityManager->createQuery(
            'SELECT b, tb
            FROM App\Entity\Bien as b
            JOIN tb.id as tb
            WHERE b.type_id = tb.id'
        )->getResult();
    }


    public function findById($id)
    {
        return $this->createQueryBuilder("l")
            ->where("l.Proprietaire = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ; // retour d'un tableau d'objet hydraté selon les données de la base
    }

    

    // /**
    //  * @return Bien[] Returns an array of Bien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bien
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
