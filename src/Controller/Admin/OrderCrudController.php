<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * Controller CRUD EasyAdmin pour la gestion des commandes.
 *
 * Ce controller permet aux administrateurs de gérer les commandes
 * via l'interface EasyAdmin.
 */
class OrderCrudController extends AbstractCrudController
{
    /**
     * Retourne le nom de classe complet de l'entité gérée.
     *
     * @return string Nom de classe complet de l'entité Order
     */
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
