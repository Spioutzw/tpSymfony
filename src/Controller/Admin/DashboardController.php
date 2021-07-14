<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\Client;
use App\Entity\Facturation;
use App\Entity\LigneFacturation;
use App\Entity\Location;
use App\Entity\Proprietaire;
use App\Entity\TypeBien;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DashboardController extends AbstractDashboardController
{


    /**
     * @Route("/admin", name="admin")
     */

    public function index(): Response
    {
        
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('admin/dashbord.html.twig');
        } else {
            return $this->redirectToRoute('app_login');
        }

        //return $this->render('admin/dashbord.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gestion du camping');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Propriétaire', 'fas fa-list', Proprietaire::class);
            yield MenuItem::linkToCrud('Client', 'fas fa-list', Client::class);
            yield MenuItem::linkToCrud('Prix des biens', 'fas fa-list', TypeBien::class);
            yield MenuItem::linkToCrud('Gestion des biens', 'fas fa-list', Bien::class);
            yield MenuItem::linkToCrud('Gestions des factures', 'fas fa-list', Facturation::class );
            yield MenuItem::linkToCrud('Gestions des locations', 'fas fa-list', Location::class );
            yield MenuItem::linkToCrud('Gestions des lignes de facture', 'fas fa-list', LigneFacturation::class );

        } else if ($this->isGranted('ROLE_PROPRIO')) {
            yield MenuItem::linkToCrud('Gestion des biens', 'fas fa-list', Bien::class);
            yield MenuItem::linkToCrud('Gestions des factures', 'fas fa-list', Facturation::class );
            yield MenuItem::linkToCrud('Gestions des locations', 'fas fa-list', Location::class );
            yield MenuItem::linkToCrud('Gestions des lignes de facture', 'fas fa-list', LigneFacturation::class );

        }
    }
}
