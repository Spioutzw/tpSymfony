<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\Client;
use App\Entity\Facturation;
use App\Entity\LigneFacturation;
use App\Entity\Location;
use App\Entity\Proprietaire;
use App\Repository\BienRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class LigneFacturationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LigneFacturation::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        
        if ($this->isGranted('ROLE_PROPRIO') || $this->isGranted('ROLE_ADMIN')) {
        
            $query = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
            $query->select("entity")
            ->innerJoin("entity.Facture", "f")
            ->innerJoin(Location::class,"l")
            ->innerJoin(Bien::class,"b")
            ->Where("b.Proprietaire = :id")
            ->setParameter('id', $this->getUser())
            ->getQuery()
            ->getResult()
            ;
            dump($query);
            return $query
        ;
        } 
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id"),
            TextField::new("Libelle"),
            IntegerField::new("Prix"),
            IntegerField::new("Reference"),
            AssociationField::new("Facture")
        ];
    }
}
