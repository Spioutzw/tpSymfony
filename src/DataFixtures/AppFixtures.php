<?php

namespace App\DataFixtures;

use App\Entity\Bien;
use App\Entity\Client;
use App\Entity\Facturation;
use App\Entity\Location;
use App\Entity\Proprietaire;
use App\Entity\TypeBien;
use App\Repository\BienRepository;
use App\Repository\ClientRepository;
use App\Repository\FacturationRepository;
use App\Repository\LigneFacturationRepository;
use App\Repository\LocationRepository;
use App\Repository\ProprietaireRepository;
use App\Repository\TypeBienRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
  private  $repoBien,
        $repoClient,
        $repoFacturation,
        $repoLigneFacturation,
        $repoLocation,
        $repoProprietaire,
        $repoTypeBien;

    public function __construct(
        BienRepository $bienRepository,
        ClientRepository $clientRepository,
        FacturationRepository $facturationRepository,
        LigneFacturationRepository $ligneFacturationRepository,
        LocationRepository $locationRepository,
        ProprietaireRepository $proprietaireRepository,
        TypeBienRepository $typeBienRepository
         )
    {
        $this->repoBien = $bienRepository;
        $this->repoClient = $clientRepository;
        $this->repoFacture = $facturationRepository;
        $this->repoLigneFacture = $ligneFacturationRepository;
        $this->repoLocation = $locationRepository;
        $this->repoProprietaire = $proprietaireRepository;
        $this->repoTypeBien = $typeBienRepository;

    }



    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $this->repoBien->resetAutoIncrement();
        $this->repoClient->resetAutoIncrement();
        //$this->repoFacturation->resetAutoIncrement();
        //$this->repoLigneFacturation->resetAutoIncrement();
        //$this->repoLocation->resetAutoIncrement();
        $this->repoProprietaire->resetAutoIncrement();
        $this->repoTypeBien->resetAutoIncrement();

        for ($i = 0; $i < 15; $i++) {
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
        $this->setReference('P31', $campingProprietaire);
        $manager->persist($campingProprietaire);

        $typesBien = ["M-H 3 personnes " => 20, "M-H 4 personnes" => 24 ,"M-H 5 personnes" => 27 ,"M-H 6-8 personnes" => 34, "Caravane 2 places" => 15, "Caravane 4 places" => 18, "Caravane 6 places" => 24, "Emplacement 8 m²" => 12, "Emplacement 12 m²" => 14 ];
            $c = 0;
            foreach($typesBien as $typeBien => $price) {
                    dump($price);
                    dump($typeBien);
                    dump($typesBien);
                    $tb = new TypeBien();
                    $tb->setLabel($typeBien)
                    ->setPrix($price);
                    $this->setReference('T'.$c, $tb);
                    $c++;
                    $manager->persist($tb);
            }

            for ($i=0; $i < 10 ; $i++) { 
                $caravane = new Bien();
                $caravane->setProprietaire($this->getReference('P31'))
                ->setUpdatedAt(new \DateTime( ))
                ->setType($this->getReference('T'. rand(4,7)));
                $manager->persist($caravane);
            }


            for ($i=0; $i < 30 ; $i++) { 
                $emplacement = new Bien();
                $emplacement->setProprietaire($this->getReference('P31'))
                ->setUpdatedAt(new \DateTime( ))
                ->setType($this->getReference('T'. rand(7,8)));
                $manager->persist($emplacement);
            }

            for ($i=0; $i < 20 ; $i++) { 
                $mobilhome = new Bien();
                $mobilhome->setProprietaire($this->getReference('P31'))
                ->setUpdatedAt(new \DateTime( ))
                ->setType($this->getReference('T'. rand(0,3)));
                $manager->persist($mobilhome);
            }

            for ($i=0; $i < 30 ; $i++) { 
                $mobilhomePropri = new Bien();
                $mobilhomePropri->setProprietaire($this->getReference('P'. rand(0,14)))
                ->setUpdatedAt(new \DateTime( ))
                ->setType($this->getReference('T'. rand(0,3)));
                $manager->persist($mobilhomePropri);
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
