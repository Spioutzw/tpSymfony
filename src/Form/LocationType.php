<?php

namespace App\Form;

use App\Entity\Bien;
use App\Entity\Client;
use App\Entity\Location;
use App\Entity\TypeBien;
use App\Repository\BienRepository;
use App\Repository\TypeBienRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Client',ClientType::class)
            ->add('DateArrive')
            ->add('dateDepart')
            ->add('nbrJourPiscineAdulte')
            ->add('nbrJourPiscineEnfant')
            ->add('nbrEnfant')
            ->add('nbrAdulte')
            
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
