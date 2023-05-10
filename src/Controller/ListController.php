<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/list', name: 'app_list')]
    public function index(): Response
    {
        $companies = [
            'Apple'     => '$1.16 trillion USD',
            'Samsung'   => '$298.68 billion USD',
            'Microsoft' => '$1.10 trillion USD',
        ];
        return $this->render('list/index.html.twig', [
            'companies' => $companies,
        ]);
    }
}
