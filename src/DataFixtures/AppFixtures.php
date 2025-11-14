<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $articles = [
            [
                'name' => 'Kit d\'hygiène recyclable',
                'shortDescription' => 'Pour une salle de bain éco-friendly',
                'fullDescription' => 'Ce kit complet zéro déchet transformera votre salle de bain en espace écologique. Composé d\'accessoires durables et recyclables, il comprend tout le nécessaire pour adopter une routine beauté respectueuse de l\'environnement. Parfait pour débuter une démarche éco-responsable au quotidien.',
                'price' => 24.99,
                'pictureLink' => 'images/hygiene.jpg',
            ],
            [
                'name' => 'Shot Tropical',
                'shortDescription' => 'Fruits frais, pressés à froid',
                'fullDescription' => 'Un concentré de vitamines et de saveurs exotiques dans ce shot énergisant aux fruits tropicaux. Pressé à froid pour préserver tous les nutriments, ce shot est idéal pour booster votre système immunitaire et commencer la journée avec vitalité. 100% naturel, sans sucres ajoutés.',
                'price' => 4.50,
                'pictureLink' => 'images/shot.jpg',
            ],
            [
                'name' => 'Gourde en bois',
                'shortDescription' => '50cl, bois d\'olivier',
                'fullDescription' => 'Gourde isotherme élégante avec finition bois d\'olivier naturel. Son double paroi en inox maintient vos boissons chaudes pendant 12h ou froides pendant 24h. Design unique et écologique, chaque pièce présente des veinures de bois différentes. Sans BPA, étanche et facile à transporter.',
                'price' => 16.90,
                'pictureLink' => 'images/gourde.jpg',
            ],
            [
                'name' => 'Disques Démaquillants x3',
                'shortDescription' => 'Solution efficace pour vous démaquiller en douceur',
                'fullDescription' => 'Lot de 3 disques démaquillants lavables en coton bio ultra-doux. Réutilisables jusqu\'à 300 fois, ils remplacent des centaines de cotons jetables. Efficaces pour enlever tout type de maquillage, même waterproof. Passent en machine à 40°C. Livrés avec leur pochette de lavage en coton bio.',
                'price' => 19.90,
                'pictureLink' => 'images/disques.jpg',
            ],
            [
                'name' => 'Bougie Lavande & Patchouli',
                'shortDescription' => 'Cire naturelle',
                'fullDescription' => 'Bougie artisanale à la cire végétale naturelle aux huiles essentielles de lavande et patchouli. Cette combinaison apaisante crée une atmosphère relaxante et zen dans votre intérieur. Durée de combustion : environ 40h. Pot en verre recyclable avec couvercle en liège naturel. Sans paraffine ni parfum synthétique.',
                'price' => 32.00,
                'pictureLink' => 'images/bougie.jpg',
            ],
            [
                'name' => 'Brosse à dent',
                'shortDescription' => 'Bois de hêtre rouge issu de forêts gérées durablement',
                'fullDescription' => 'Brosse à dents écologique en bois de hêtre rouge certifié FSC. Manche ergonomique et poils souples en nylon sans BPA pour un brossage efficace et doux. Alternative durable aux brosses en plastique, biodégradable et compostable (après retrait des poils). Design épuré et élégant pour votre salle de bain zéro déchet.',
                'price' => 5.40,
                'pictureLink' => 'images/brosseADent.jpg',
            ],
            [
                'name' => 'Kit couvert en bois',
                'shortDescription' => 'Revêtement Bio en olivier & sac de transport',
                'fullDescription' => 'Set de couverts nomades en bois d\'olivier : fourchette, couteau et cuillère dans leur étui de transport en lin bio. Parfait pour les déjeuners au bureau, pique-niques ou voyages. Légers, résistants et élégants, ces couverts réutilisables vous permettent de dire non aux couverts jetables. Lavables à la main, traités à l\'huile végétale.',
                'price' => 12.30,
                'pictureLink' => 'images/couverts.jpg',
            ],
            [
                'name' => 'Nécessaire, déodorant Bio',
                'shortDescription' => '50ml déodorant à l\'eucalyptus',
                'fullDescription' => 'Déodorant solide bio à l\'eucalyptus, efficace 24h. Formule naturelle sans sels d\'aluminium, sans alcool et sans parabènes. Respecte l\'équilibre de votre peau tout en neutralisant les odeurs. Rechargeable dans son étui en carton recyclé. Convient aux peaux sensibles. Fabriqué en France avec des ingrédients biologiques certifiés.',
                'price' => 8.50,
                'pictureLink' => 'images/deo.jpg',
            ],
            [
                'name' => 'Savon Bio',
                'shortDescription' => 'Thé, Orange & Girofle',
                'fullDescription' => 'Savon artisanal bio aux huiles essentielles de thé, orange douce et girofle. Saponifié à froid pour conserver toutes les propriétés des huiles végétales. Nettoyant, tonifiant et délicatement parfumé, ce savon surgras à 8% convient à tous les types de peaux. 100% naturel, vegan et biodégradable. Fabriqué en France, 100g.',
                'price' => 18.90,
                'pictureLink' => 'images/savon.jpg',
            ],
        ];

        $this->createArticles($articles);

        $users = [
            [
                'email' => 'admin@greengoodies.com',
                'plainPassword' => 'admin',
                'firstName' => 'Admin',
                'lastName' => 'User',
                'roles' => ['ROLE_ADMIN'],
                'apiEnabled' => true,
            ],
            [
                'email' => 'user@greengoodies.com',
                'plainPassword' => 'user',
                'firstName' => 'Regular',
                'lastName' => 'User',
                'roles' => [],
                'apiEnabled' => false,
            ],
        ];

        $this->createUsers($users);
    }

    private function createArticles(array $articles): void
    {
        foreach ($articles as $articleData) {
            ArticleFactory::createOne($articleData);
        }
    }

    private function createUsers(array $users): void
    {
        foreach ($users as $userData) {
            UserFactory::createOne($userData);
        }
    }
}
