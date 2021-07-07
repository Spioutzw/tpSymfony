<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\TypeBien;
use App\Repository\BienRepository;
use App\Repository\TypeBienRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Security\Core\Security;

class BienCrudController extends AbstractCrudController
{

    private $repoBien;

    public function __construct(BienRepository $BienRepository)
    {
        $this->repoBien = $BienRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Bien::class;
    }

   

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('Type', 'Type de bien');

        if ($this->isGranted('ROLE_PROPRIO')) {
            yield AssociationField::new('Proprietaire')->setQueryBuilder(function(BienRepository $bienRepository) {
                 $bienRepository->findById($this->getUser());
            })
            ;
            
            
        } else if($this->isGranted('ROLE_ADMIN')) {
            yield AssociationField::new('Proprietaire');
        }
        yield TextField::new('imageFile', 'Image')
            ->hideOnIndex()
            ->setFormType(VichImageType::class);
        yield ImageField::new('image')
            ->setBasePath('/images/biens')
            ->onlyOnIndex();
    }
}
