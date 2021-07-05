<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\TypeBien;
use App\Repository\BienRepository;
use App\Repository\TypeBienRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\Node\Expr\Yield_;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
          yield IdField::new('id')->onlyOnIndex();
          yield AssociationField::new('Type','Type de bien');
          yield AssociationField::new('Proprietaire');
          yield TextField::new('imageFile','Image')
          ->setFormType(VichImageType::class)
          ->onlyWhenUpdating()
          ->setTranslationParameters(['form.label.delete'=>'Delete'])
          
          ;
          yield ImageField::new('image')
          ->setBasePath('/images/biens')
          ->onlyOnIndex()
          ;
          

    
    }
    
}
