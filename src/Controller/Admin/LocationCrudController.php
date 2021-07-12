<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
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
            AssociationField::new("Client")
        ];
    }
    
}
