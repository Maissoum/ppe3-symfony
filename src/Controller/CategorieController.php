<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Repository\CatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/Categorie', name: 'categorie', methods: ['GET'])]
    public function listeCat(CatRepository $repo): Response
    {
        $cats = $repo->findAll();

        return $this->render('categorie/listeCategorie.html.twig', [
            'lescats' => $cats
        ]);
    }

    #[Route('/Categorie/{id}', name: 'fichecategorie', methods: ['GET'])]
    public function ficheCat(Cat $cat): Response
    {
        return $this->render('categorie/ficheCategorie.html.twig', [
            'lecat' => $cat
        ]);
    }
}
