<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\Facturation;
use App\Entity\Location;
use App\Entity\Proprietaire;
use App\Repository\BienRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FacturationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Facturation::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        
        if ($this->isGranted('ROLE_PROPRIO') || $this->isGranted('ROLE_ADMIN')) {
        
            $query = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
            $query->select("entity")
            ->innerJoin(Location::class,"l")
            ->innerJoin(Bien::class,"b")
            ->where("b.Proprietaire = :id")
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
            IdField::new("id")->onlyOnIndex(),
            DateField::new("dateFacturation","Date Facturation",),
            IntegerField::new("numeroIdentification","Numero Identification"),
            AssociationField::new("Client"),
            TextField::new('facturePDFFile', 'PDF')
            ->hideOnIndex()
            ->setFormType(VichFileType::class),
             ImageField::new('facturePDF','pdf')
             ->setTemplatePath("/home/facture.html.twig")
            ->onlyOnIndex()
        ];
    }
    
}
