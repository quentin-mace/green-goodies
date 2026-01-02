<?php

namespace App\Controller\Admin;

use App\Entity\OrderLine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * Controller CRUD EasyAdmin pour la gestion des lignes de commande.
 *
 * Ce controller permet aux administrateurs de gérer les lignes de commande
 * via l'interface EasyAdmin.
 */
class OrderLineCrudController extends AbstractCrudController
{
    /**
     * Retourne le nom de classe complet de l'entité gérée.
     *
     * @return string Nom de classe complet de l'entité OrderLine
     */
    public static function getEntityFqcn(): string
    {
        return OrderLine::class;
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
