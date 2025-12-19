<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller du tableau de bord d'administration EasyAdmin.
 *
 * Ce controller configure le tableau de bord et le menu de navigation
 * pour l'interface d'administration.
 */
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    /**
     * Redirige vers la page d'index des articles par défaut.
     *
     * @return Response Redirection vers la liste des articles
     */
    public function index(): Response
    {
        return $this->redirectToRoute('admin_article_index');
    }

    /**
     * Configure le tableau de bord EasyAdmin.
     *
     * @return Dashboard Configuration du tableau de bord
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Green Goodies');
    }

    /**
     * Configure les éléments du menu de navigation.
     *
     * @return iterable Liste des éléments du menu
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Articles', 'fas fa-box', Article::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-receipt', Order::class);
        yield MenuItem::linkToCrud('Lignes de commande', 'fas fa-list', OrderLine::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
    }
}
