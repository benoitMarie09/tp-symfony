<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/create_article', name: 'app_article')]
    public function create( Request $request, ManagerRegistry $doctrine ): Response
    {
        $article = new Article(); // Création d'un article vide
        // Création d'un objet formulaire spécifique à un article
        $form = $this->createForm(ArticleType::class, $article);
        // Récupération du $_GET ou du $_POST
        $form->handleRequest($request);
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        // Si le formulaire est envoyé
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // Ajout de la date de l'article
            $article->setDate(new DateTime());
            // Ajout de l'identifiant de l'utilisateur
            $article->setUser($user);
            // Sauvegarde dans la base de données
            $em = $doctrine->getManager();
            $em->persist($article);
            $em->flush();
            $this->addFlash('success', 'Votre article est enregistré');
            // Redirection vers la page login
            return $this->redirectToRoute('show_all_articles');
        }
        return $this->render('article/index.html.twig', [
        'form' => $form->createView(),
        ]);
    }

    #[Route('/update_article/{id}', name: 'app_article')]
    public function update( Request $request, ManagerRegistry $doctrine ): Response
    {
        $article = new Article(); // Création d'un article vide
        // Création d'un objet formulaire spécifique à un article
        $form = $this->createForm(ArticleType::class, $article);
        // Récupération du $_GET ou du $_POST
        $form->handleRequest($request);
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        // Si le formulaire est envoyé
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // Ajout de la date de l'article
            $article->setDate(new DateTime());
            // Ajout de l'identifiant de l'utilisateur
            $article->setUser($user);
            // Sauvegarde dans la base de données
            $em = $doctrine->getManager();
            $em->persist($article);
            $em->flush();
            $this->addFlash('success', 'Votre article est enregistré');
            // Redirection vers la page login
            return $this->redirectToRoute('show_all_articles');
        }
        return $this->render('article/index.html.twig', [
        'form' => $form->createView(),
        ]);
    }

    #[Route('/articles', name: 'show_user_articles')]
    public function showUserArticles(): Response
    {
        // Récupération de l'utilisateur connecté
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        // Récupération des articles de l'utilisateur connecté
        $articles = $user->getArticles();
        return $this->render('article/showUserArticles.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/', name: 'show_all_articles')]
    public function showAllArticles( ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request ): Response
    {
        //$dql   = "SELECT a FROM AcmeMainBundle:Article a";
        //$query = $em->createQuery($dql);
        $articles = $doctrine->getRepository(article::class)->findAll();

        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('article/showAll.html.twig', 
            ['pagination' => $pagination]
        );
    }

    #[Route('/articles/{id}', name: 'show_article')]
    public function show( ManagerRegistry $doctrine, int $id ): Response
    {
        // Récupération de l'utilisateur connecté
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $article = $doctrine->getRepository(article::class)->find( $id );
        if( ! $article )
        {
            throw $this->createNotFoundException( 'This article is not one of yours or doesn\'t exist.' );
        }
        return $this->render( 'article/show.html.twig', [
            'article' => $article
        ] );
    }
}
