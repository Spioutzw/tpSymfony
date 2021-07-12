<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Repository\BienRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BienCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bien::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {

        if ($this->isGranted('ROLE_PROPRIO')) {
            $query = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

            $query->andWhere("entity.Proprietaire = :id")
                ->setParameter('id', $this->getUser());
            return $query;

        } else if ($this->isGranted('ROLE_ADMIN')) {
            $query = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
            $query->getQuery();
            return $query;
        }
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('Type', 'Type de bien');
        yield AssociationField::new('Proprietaire');
       // yield AssociationField::new('Facturation');
        yield TextField::new('imageFile', 'Image')
            ->hideOnIndex()
            ->setFormType(VichImageType::class);
        yield ImageField::new('image')
            ->setBasePath('/images/biens')
            ->onlyOnIndex();
    }
}
