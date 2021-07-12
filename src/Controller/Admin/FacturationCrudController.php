<?php

namespace App\Controller\Admin;

use App\Entity\Facturation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class FacturationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Facturation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id"),
            DateField::new("Date Facturation"),
            IntegerField::new("Numero Identification"),
            AssociationField::new("Client")
        ];
    }
    
}
