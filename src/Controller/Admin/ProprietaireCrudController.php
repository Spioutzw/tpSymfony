<?php

namespace App\Controller\Admin;

use App\Entity\Proprietaire;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class ProprietaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Proprietaire::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        
        if ($this->isGranted('ROLE_PROPRIO') || $this->isGranted('ROLE_ADMIN')) {
        
            $query = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
            $query->select("entity")
            ->Where("entity = :id")
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
            IdField::new('Id'),
            TextField::new('Nom'),
            TelephoneField::new('Telephone'),
            EmailField::new('Email'),
            TextField::new('Adresse'),
            TextField::new('Pass'),
            BooleanField::new('Role')

        ];
    }
    
}
