<?php

namespace App\DataFixtures;

use App\Entity\Bien;
use App\Entity\Client;
use App\Entity\Location;
use App\Entity\Proprietaire;
use App\Entity\TypeBien;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $proprietaire = new Proprietaire();
            $proprietaire->setAdresse($faker->address)
                ->setNom($faker->name)
                ->setEmail($faker->companyEmail)
                ->setTelephone($faker->phoneNumber)
                ->setRole(false)
                ->setPass($faker->password);
            $this->setReference('P'.$i, $proprietaire);
            $manager->persist($proprietaire);
        }

        $campingProprietaire = new Proprietaire();
        $campingProprietaire->setAdresse($faker->address)
            ->setNom("Camping de l’Espadrille Volante")
            ->setEmail($faker->companyEmail)
            ->setTelephone($faker->phoneNumber)
            ->setRole(true)
            ->setPass($faker->password);
        $this->setReference('P0', $campingProprietaire);
        $manager->persist($campingProprietaire);

        $typesBien = ["M-H 3 personnes " => 20, "M-H 4 personnes" => 24 ,"M-H 5 personnes" => 27 ,"M-H 6-8 personnes" => 34, "Caravane 2 places" => 15, "Caravane 4 places" => 18, "Caravane 6 places" => 24, "Emplacement 8 m²" => 12, "Emplacement 8 m²" => 14 ];
            $c = 0;
            foreach($typesBien as $price => $typeBien) {
                    $tb = new TypeBien();
                    $tb->setLabel($typeBien)
                    ->setPrix($price);
                    $this->setReference('T'.$c, $tb);
                    $c++;
                    $manager->persist($tb);
            }

            for ($i=0; $i < 10 ; $i++) { 
                $caravane = new Bien();
                $caravane->set
            }
        
            
        



        // for ($i=0; $i < 50 ; $i++) { 
        // $location = new Location();
        // $location->setDateArrive($faker->dateTimeInInterval('',15))
        // ->setDateDepart($faker->dateTimeInInterval('',15))
        // ->setNbrAdulte(rand(0,6))
        // ->setNbrEnfant(rand(0,6))
        // ->setNbrJourPiscineAdulte(rand(0,6))
        // ->setNbrJourPiscineEnfant(rand(0,6))
        // ->set
        //  $manager->persist($location);
        // }


        $manager->flush();
    }
}
