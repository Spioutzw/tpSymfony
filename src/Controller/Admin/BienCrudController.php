<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\TypeBien;
use App\Repository\BienRepository;
use App\Repository\TypeBienRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use PhpParser\Node\Expr\Yield_;

class BienCrudController extends AbstractCrudController
{

    private $repoTypeBien;

    public function __construct(TypeBienRepository $typeBienRepository)
    {
        $this->repoTypeBien = $typeBienRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Bien::class;
    }

   

    
    public function configureFields(string $pageName): iterable
    {
          yield IdField::new('Id');
          yield FormField::addPanel('TypeBien');
          yield AssociationField::new('Type');
          yield AssociationField::new('Proprietaire');
    
    }
    
}
