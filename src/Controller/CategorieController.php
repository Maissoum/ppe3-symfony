<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Form\FiltreCatType;
use App\Repository\CatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/Categorie', name: 'categorie', methods: ['GET'])]
    public function listeCat(CatRepository $repo, Request $request): Response
    {
        // Création du formulaire de filtre
        $formFiltreCat = $this->createForm(FiltreCatType::class, null, [
            'method' => 'GET'
        ]);
        $formFiltreCat->handleRequest($request);

        // Récupération du nom recherché
        $nom = null;
        if ($formFiltreCat->isSubmitted() && $formFiltreCat->isValid()) {
            $nom = $formFiltreCat->get('nom')->getData();
        }

        // Recherche dans le repository
        $cats = $repo->findByNom($nom);

        return $this->render('categorie/listeCategorie.html.twig', [
            'lescats' => $cats,
            'formFiltreCat' => $formFiltreCat->createView(),
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
