<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActeurController extends AbstractController
{
    #[Route('/acteur', name: 'acteur')]
    public function listeActeur(ActeurRepository $repo): Response
    {
        $acteur =$repo->findAll();
        return $this->render('acteur/listeActeur.html.twig', [
            'lesacteurs' => $acteurs
            
        ]);
    }

    #[Route('/Acteur/{id}', name: 'ficheActeur', methods: ['GET'])]

    public function ficheFilms(Flm $film): Response
    {
        return $this->render('film/ficheActeur.html.twig' , [
            'leacteur' => $acteur
        ]);
    }

}
