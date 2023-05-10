<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Article;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('Mon Projet Symfony')
            // you can include HTML contents too (e.g. to link to an image)
            //->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>')
            // the path defined in this method is passed to the Twig asset() function
            //->setFaviconPath('favicon.svg')
            ->setTranslationDomain('my-custom-domain')
            ->setTextDirection('ltr')
            ->renderContentMaximized()
            ->disableUrlSignatures()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Articles'),
            MenuItem::linkToCrud('Article', 'fa fa-tags', Article::class),

            MenuItem::section('Users'),
            MenuItem::linkToCrud('User', 'fa fa-user', User::class),
        ];
    }
}
