<?php

namespace App\Controller\Admin;


use App\Entity\Location;
use App\Entity\Proprietaire;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        
        if ($this->isGranted('ROLE_PROPRIO') || $this->isGranted('ROLE_ADMIN')) {
            $query = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
            $query->select("entity")
            ->innerJoin("entity.Bien","b")
            ->Where("b.Proprietaire = :id")
            ->setParameter('id', $this->getUser())
            ->getQuery()
            ->getResult()
            ;
            return $query
        ;
        } 
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new("DateArrive","Date d'arrivé"),
            DateField::new("DateDepart","Date de départ"),
            IntegerField::new("NbrJourPiscineAdulte",'Nbr jour à la piscine Adulte'),
            IntegerField::new("NbrJourPiscineEnfant",'Nbr jour à la piscine Enfant'),
            IntegerField::new("NbrEnfant","Nombre d'enfant"),
            IntegerField::new("NbrAdulte","Nombre d'adulte"),
            AssociationField::new("Bien"),
            AssociationField::new("Client"),
        ];
    }
    
    
}
