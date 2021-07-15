<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Facturation;
use App\Entity\LigneFacturation;
use App\Entity\Location;
use App\Entity\Tarif;
use App\Form\LocationType;
use App\Repository\BienRepository;
use App\Repository\ClientRepository;
use App\Repository\FacturationRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;

class HomeController extends AbstractController
{

    private $repoBien,
            $repoClient,
            $repoFacturation;


    public function __construct(BienRepository $bienRepository, ClientRepository $clientRepository, FacturationRepository $facturationRepository)
    {
        $this->repoBien = $bienRepository;
        $this->repoClient = $clientRepository;
        $this->repoFacturation = $facturationRepository;
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

     public function detailBook(int $id, Request $request, MailerInterface $mailer, ClientRepository $client)
     {

        define("piscineEnfant", 1  );
        define("piscineAdulte", 1.5  );
        define("TaxeAdulte", 0.35  );
        define("TaxeEnfant", 0.60  );
        


         $location = new Location();
         $facture = new Facturation();
         $ligneFactureTaxe = new LigneFacturation();
         $ligneFacturePiscine = new LigneFacturation();
         $ligneFactureBienPrix = new LigneFacturation();

         
         $lastfacture = $this->repoFacturation->findLastFacture();
         $bien = $this->repoBien->find($id);
       

         $location->setBien($bien);

         $form = $this->createForm(LocationType::class, $location);
         $form->handleRequest($request);
         
        
         if ($form->isSubmitted() && $form->isValid()) {
    
             $facture->setClient($location->getClient())
             ->setDateFacturation(new DateTime("now"))
             ->setNumeroIdentification( ($lastfacture) ? ($lastfacture[0]->getNumeroIdentification()) + 1 : 1) ;

             $ligneFactureTaxe->setFacture($facture)
             ->setLibelle("Taxe")
             ->setReference(1)
             ->setPrix(strtotime($location->getDateArrive()->diff($location->getDateDepart())->format("Y-M-D")) * $location->getNbrEnfant() * TaxeEnfant + $location->getNbrAdulte() * TaxeAdulte);

             $ligneFacturePiscine->setFacture($facture)
             ->setLibelle("Piscine")
             ->setReference(2)
             ->setPrix(strtotime($location->getDateArrive()->diff($location->getDateDepart())->format("Y-M-D")) * $location->getNbrJourPiscineAdulte() * piscineAdulte + $location->getNbrJourPiscineEnfant() * piscineEnfant);

             $ligneFactureBienPrix->setFacture($facture)
             ->setLibelle("Prix du bien")
             ->setReference(3)
             ->setPrix(($location->getDateArrive()->diff($location->getDateDepart())->format("%a")) * $location->getBien()->getType()->getPrix());
               
           
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($location);
             $entityManager->persist($facture);
             $entityManager->persist($ligneFactureTaxe);
             $entityManager->persist($ligneFacturePiscine);
             $entityManager->persist($ligneFactureBienPrix);
             $entityManager->flush();

             $dompdf = new Dompdf();

              $html = $this->renderView("home/facture.html.twig", [
                  'bien' => $bien,
                  'client' => $client->findLastUser(),
                  'location' => $location,
                  'facture' => $facture,
                  'ligneFactureBienPrix' => $ligneFactureBienPrix,
                  'ligneFacturePiscine' => $ligneFacturePiscine,
                  'ligneFactureTaxe' => $ligneFactureTaxe
              ]);

             $dompdf->loadHtml($html)
             ->setPaper('A4');
             $dompdf->render();



             $email = (new Email())
             ->from(new Address('matthieu.roquigny.camping@gmail.com', 'Espadrille Volante Bot'))
             ->to($this->getUser())
             ->subject("Facture Reservation")
             ->attach();

             return $this->redirectToRoute('lb');

             

         }

         return $this->render("bien/show.html.twig",[
             'biens' => $bien,
             'form' => $form->createView()
         ]);
     }

     public function detailFacture() {
            
     }
}
