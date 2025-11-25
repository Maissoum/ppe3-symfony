<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/Categorie', name: 'app_Categorie')]
    public function index(): Response
    {
        return $this->render('categorie/listeCategorie.html.twig');
    }
}