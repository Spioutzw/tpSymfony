<?php

namespace App\Controller\Admin;

use App\Entity\Proprietaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProprietaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Proprietaire::class;
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
