<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * Controller CRUD EasyAdmin pour la gestion des utilisateurs.
 *
 * Ce controller permet aux administrateurs de gérer les utilisateurs
 * via l'interface EasyAdmin.
 */
class UserCrudController extends AbstractCrudController
{
    /**
     * Retourne le nom de classe complet de l'entité gérée.
     *
     * @return string Nom de classe complet de l'entité User
     */
    public static function getEntityFqcn(): string
    {
        return User::class;
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
