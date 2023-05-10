<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextareaField::new('contenu'),
            DateTimeField::new('date')->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        // Création d'un objet Article vide
        $article = new Article();
        // Ajout de l"utilisateur qui l'a créé
        $article->setUser($this->getUser());
        // Ajout de la date de création
        $article->setDate(new DateTime());
        // L'article se créé tout seul, mais c'est de la magie ^^
        
        return $article;
    }
    
}
