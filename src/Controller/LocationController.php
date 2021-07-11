<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\BienRepository;
use App\Repository\LocationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/location")
 */
class LocationController extends AbstractController
{

    private $repoBien;

    public function __construct(BienRepository $bienRepository)
    {
        $this->repoBien = $bienRepository;
    }
    /**
     * @Route("/", name="location_index", methods={"GET"})
     */
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('location/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="location_new", methods={"GET","POST"})
     */
    public function new(int $id , Request $request): Response
    {
        
        $location = new Location();
        $client = new Client();
        $form = $this->createForm(LocationType::class, $location);
        $bien = $this->repoBien->find($id);
        $form->handleRequest($request);
        

       // $request->request->get("location")[""]

        dump($bien);
        dump($form);
        dump($client);
        dump('tata');
        
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $client->setNom($request->request->get("location")["Client"]["Nom"])
            ->setPrenom($request->request->get("location")["Client"]["Prenom"])
            ->setTelephone($request->request->get("location")["Client"]["Telephone"])
            ->setEmail($request->request->get("location")["Client"]["Email"])
            ->setAdresse($request->request->get("location")["Client"]["Adresse"])
            ->setAccord($request->request->get("location")["Client"]["Accord"]);

            $month = $request->request->get("location")["DateArrive"]["month"];
            $day = $request->request->get("location")["DateArrive"]["day"];
            $year = $request->request->get("location")["DateArrive"]["year"];
            
            $startMonth = $request->request->get("location")["dateDepart"]["month"];
            $startDay = $request->request->get("location")["dateDepart"]["day"];
            $startYear = $request->request->get("location")["dateDepart"]["year"];

            $start = new DateTime($year . '-' . $month . '-' . $day);
            $end = new DateTime($startYear . '-' . $startMonth . '-' . $startDay);

            $location->setClient($client)
            ->setBien($bien)
            ->setDateArrive($start)
            ->setDateDepart($end)
            ->setNbrAdulte($request->request->get("location")["nbrJourPiscineAdulte"])
            ->setNbrJourPiscineEnfant($request->request->get("location")["nbrJourPiscineEnfant"])
            ->setNbrAdulte($request->request->get("location")["nbrNbrAdulte"])
            ->setNbrEnfant($request->request->get("location")["nbrEnfant"])
;
            $entityManager->persist($location);
            $entityManager->persist($client);
            $entityManager->flush();
            dump('totu');

            return $this->redirectToRoute('location_index', [], Response::HTTP_SEE_OTHER);
        } else {
            dump('toto');
        }

        return $this->renderForm('location/new.html.twig', [
            'location' => $location,
            'client' => $client,
            'form' => $form,

        ]);
    }

    /**
     * @Route("/{id}", name="location_show", methods={"GET"})
     */
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="location_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Location $location): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('location/edit.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="location_delete", methods={"POST"})
     */
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($location);
            $entityManager->flush();
        }

        return $this->redirectToRoute('location_index', [], Response::HTTP_SEE_OTHER);
    }
}
