<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

     public function listBien(BienRepository $bienRepository): Response
     {
        $results = $bienRepository->findAll();

         return $this->render('home/listBien.html.twig', [
            'results' => $results,
         ]);
     }

     /**
      * @Route("/listbiens/{id}", methods={"GET"}, name="det")
      */

     public function detailBook(int $id)
     {
 //        $livre = $livreRepository->find($id);
         $biens =$this->repoBien->find($id);
         return $this->render("bien/show.html.twig",[
             'biens' => $biens
         ]);
     }
}
