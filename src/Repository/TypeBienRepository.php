<?php

namespace App\Repository;

use App\Entity\TypeBien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeBien|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBien|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBien[]    findAll()
 * @method TypeBien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBien::class);
    }

    public function resetAutoIncrement() {
        $tableName =$this->getClassMetadata()->getTableName();
        $connection = $this->getEntityManager()->getConnection();
        $connection->executeStatement("ALTER TABLE " . $tableName . " AUTO_INCREMENT = 1;");

    }

    public function findCampingBien() {
        $entityManager = $this->getEntityManager();
        $entityManager->createQuery(
        'SELECT * 
        FROM bien AS b
        JOIN type_bien AS tb
        ON b.type_id = tb.id
        WHERE proprietaire_id = 31
        '
        );
    }

    public function selectLabel() {
        $entityManager = $this->getEntityManager();

         $entityManager->createQuery(
            'SELECT b, tb
            FROM App\Entity\Bien b
            JOIN tp.id tb
            WHERE b.type_id = tp.id
            AND 
            '
        );
    }
    // /**
    //  * @return TypeBien[] Returns an array of TypeBien objects
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
    public function findOneBySomeField($value): ?TypeBien
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
