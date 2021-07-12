<?php

namespace App\Controller\Admin;

use App\Entity\LigneFacturation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LigneFacturationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LigneFacturation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('Libelle'),
            NumberField::new('Prix'),
            IntegerField::new('Reference'),
            AssociationField::new('Facture')
        ];
    }
    
}
