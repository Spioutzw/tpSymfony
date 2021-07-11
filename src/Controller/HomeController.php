<?php

namespace App\Controller;

use App\Entity\Facturation;
use App\Entity\LigneFacturation;
use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\BienRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Faker;

class HomeController extends AbstractController
{

    private $repoBien;

    public function __construct(BienRepository $bienRepository)
    {
        $this->repoBien = $bienRepository;
    }


    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
       dump($results = $this->repoBien->findById($this->getUser()));

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'results' => $results
        ]);
    }

    /**
     * @Route("/listbiens", name="lb")
     */

     public function listBien(BienRepository $bienRepository, PaginatorInterface $paginator, Request $request): Response
     {
        $results = $paginator->paginate($bienRepository->findAll(),$request->query->getInt('page',1),9);
        
         return $this->render('home/listBien.html.twig', [
            'results' => $results,
         ]);
     }

     /**
      * @Route("/listbiens/{id}", methods={"GET","POST"}, name="det")
      */

     public function detailBook(int $id, Request $request)
     {

        define("piscineEnfant", 1  );
        define("piscineAdulte", 1.5  );
        

        $faker = Faker\Factory::create('fr_FR');

         $location = new Location();
         $facture = new Facturation();
         $ligneFacture= new LigneFacturation();

         $bien = $this->repoBien->find($id);
         $location->setBien($bien);
         


         $facture->setClient($_POST['location']["Client"])
         ->setDateFacturation(new DateTime("now"))
         ->setNumeroIdentification($faker->bankAccountNumber);

         $ligneFacture->setFacture($facture->getId())
         ->setPrix($bien->getType()->getPrix() * ($location->getDateArrive() - $location->getDateDepart()) + $location->getNbrJourPiscineAdulte() * piscineAdulte + $location->getNbrJourPiscineEnfant() * piscineEnfant )
         ->setReference($faker->randomNumber())
         ->setLibelle();


         $form = $this->createForm(LocationType::class, $location);
         $form->handleRequest($request);


         if ($form->isSubmitted() && $form->isValid()) {

             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($location);
             $entityManager->flush();
             return $this->redirectToRoute('location_index', [], Response::HTTP_SEE_OTHER);

         }

         return $this->render("bien/show.html.twig",[
             'biens' => $bien,
             'form' => $form->createView()
         ]);
     }
}
