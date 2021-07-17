<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Facturation;
use App\Entity\LigneFacturation;
use App\Entity\Location;
use App\Entity\Tarif;
use App\Form\BienType;
use App\Form\LocationType;
use App\Repository\BienRepository;
use App\Repository\ClientRepository;
use App\Repository\FacturationRepository;
use App\Repository\LigneFacturationRepository;
use App\Repository\LocationRepository;
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
            $repoLigneFacture,
            $repoLocation,
            $repoFacturation;


    public function __construct(BienRepository $bienRepository, ClientRepository $clientRepository, FacturationRepository $facturationRepository, LigneFacturationRepository $ligneFacturationRepository, LocationRepository $locationRepository)
    {
        $this->repoBien = $bienRepository;
        $this->repoClient = $clientRepository;
        $this->repoFacturation = $facturationRepository;
        $this->repoLigneFacture = $ligneFacturationRepository;
        $this->repoLocation = $locationRepository;
    }


    /**
     * @Route("/home", name="home", methods={"GET","POST"})
     */
    public function index(): Response
    {
        $form = $this->createForm(BienType::class);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listebiensf", name="lbf", methods={"GET","POST"})
     */

     public function filtreBien(Request $request, PaginatorInterface $paginator) {

         $typeBien = $request->get('bien')["Type"];

        $biens =$paginator->paginate($this->repoBien->findBytype($typeBien),$request->query->getInt('page',1),9);

        

        return $this->render('home/filtreBien.html.twig', [
                'typeBien' => $typeBien,
                'biens' => $biens
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
      * 
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
         $dompdf = new Dompdf();

         
         $lastfacture = $this->repoFacturation->findLastFacture();
         $bien = $this->repoBien->find($id);
       

         $location->setBien($bien);

         $form = $this->createForm(LocationType::class, $location);
         $form->handleRequest($request);
         
        
         if ($form->isSubmitted() && $form->isValid()) {
    
             $facture->setClient($location->getClient())
             ->setDateFacturation(new DateTime("now"))
             ->setNumeroIdentification( ($lastfacture) ? ($lastfacture[0]->getNumeroIdentification()) + 1 : 1)
              ;

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
               
             dump(($location->getDateArrive()->diff($location->getDateDepart())->format("%a")) * $location->getBien()->getType()->getPrix());
           
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($location);
             
             $entityManager->persist($ligneFactureTaxe);
             $entityManager->persist($ligneFacturePiscine);
             $entityManager->persist($facture);
             $entityManager->persist($ligneFactureBienPrix);
             $entityManager->flush();

              $html = $this->render("home/factureEmail.html.twig", [
                  'bien' => $bien,
                  'client' => $client->findLastUser(),
                  'location' => $location,
                  'facture' => $facture,
                  'ligneFactureBienPrix' => $ligneFactureBienPrix,
                  'ligneFacturePiscine' => $ligneFacturePiscine,
                  'ligneFactureTaxe' => $ligneFactureTaxe
              ]);

              $dompdf->loadHtml($html->getContent());
              $dompdf->render();
              $output = $dompdf->output();
              $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/facture/';

              
            
              $Client = $client->findLastUser();
              $ClientNom = $Client[0]->getNom()? : $Client->getNom() ;
              $ClientPrenom = $Client[0]->getpreNom() ?:  $Client->getpreNom()  ;

              $pdffilepath = $publicDirectory . $ClientNom."_".$ClientPrenom."_facture.pdf";
              file_put_contents($pdffilepath,$output);

             

            $emailClient = $client->findLastUser();

             $email = (new Email())
             ->from(new Address('matthieu.roquigny.camping@gmail.com', 'Espadrille Volante Bot'))
             ->to($emailClient["0"]->getEmail())
             ->subject("Facture Reservation")
             ->attachFromPath($pdffilepath, $ClientNom."_".$ClientPrenom."_facture.pdf");

             
             $mailer->send($email);


             $entityManager->flush();



             return $this->redirectToRoute('detf');

         }

         return $this->render("bien/show.html.twig",[
             'biens' => $bien,
             'form' => $form->createView()
         ]);
     }

     /**
      * @Route("/facture/", methods={"GET","POST"}, name="detf")
      */

      public function getFacture (): Response {
            $facture = $this->repoFacturation->findLastFacture();
            $location = $this->repoLocation->findLastLocation();
            $client = $this->repoClient->findLastUser();
            $ligneFacture = $this->repoLigneFacture->findLastFacture();

            return $this->render("home/facture.html.twig", [
               //dump($ligneFacture),
                'client' => $client,
                'location' => $location,
                'facture' => $facture,
                'ligneFacture' => $ligneFacture
            ]);
      }
     
}
