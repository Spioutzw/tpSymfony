<?php

namespace App\Controller\Admin;

use App\Entity\LigneFacturation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LigneFacturationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LigneFacturation::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
