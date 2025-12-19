<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * Controller CRUD EasyAdmin pour la gestion des articles.
 *
 * Ce controller permet aux administrateurs de créer, lire, modifier
 * et supprimer des articles via l'interface EasyAdmin.
 */
class ArticleCrudController extends AbstractCrudController
{
    /**
     * Retourne le nom de classe complet de l'entité gérée.
     *
     * @return string Nom de classe complet de l'entité Article
     */
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    /**
     * Configure les champs affichés dans les formulaires et listes EasyAdmin.
     *
     * @return iterable Liste des champs à afficher
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            ImageField::new('pictureLink')->setUploadDir('public/images'),
            TextField::new('shortDescription'),
            TextField::new('fullDescription')->hideOnIndex(),
            NumberField::new('price'),
        ];
    }

    /**
     * Configure les actions disponibles dans l'interface EasyAdmin.
     *
     * @return Actions Configuration des actions modifiée
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
