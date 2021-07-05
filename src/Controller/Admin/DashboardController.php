<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\Client;
use App\Entity\Proprietaire;
use App\Entity\TypeBien;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    /**
     * @Route("/admin", name="admin")
     */

    public function index(): Response
    {
        return $this->render('admin/dashbord.html.twig');
    }

    public function linkRedirect() {
        $this->adminUrlGenerator
            ->setController(ProprietaireCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gestion du camping');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Propriétaire', 'fas fa-list', Proprietaire::class);
        yield MenuItem::linkToCrud('Client', 'fas fa-list', Client::class);
        yield MenuItem::linkToCrud('Prix des biens', 'fas fa-list', TypeBien::class);
        yield MenuItem::linkToCrud('Gestion des biens', 'fas fa-list', Bien::class);

    }
}
