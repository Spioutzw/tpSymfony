<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function resetAutoIncrement() {
        $tableName =$this->getClassMetadata()->getTableName();
        $connection = $this->getEntityManager()->getConnection();
        $connection->executeStatement("ALTER TABLE " . $tableName . " AUTO_INCREMENT = 1;");

    }

    // public function locationByProprio() {
    //     return $this->createQueryBuilder("l")
    //     ->select("l.location.*","l.proprietaire.nom")
    //     ->from("l.location","L")
    //     ->innerJoin("L","l.bien","b", "b.id = L.bien_id")
    //     ->innerJoin("b","l.propietaire","p","p.id = b.proprietaire_id")
    //     ->andWhere("l.Proprietaire = :id")
    //     ->setParameter('id', $this->)
        
    //     ;
    // }


    // /**
    //  * @return Location[] Returns an array of Location objects
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
    public function findOneBySomeField($value): ?Location
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
