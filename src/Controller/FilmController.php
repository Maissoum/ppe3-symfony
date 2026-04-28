<?php

namespace App\Controller;

use App\Entity\Flm;
use App\Repository\FlmRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'film', methods: ['GET'])]
    public function listeFilms(FlmRepository $repo): Response
    {
        $films =$repo->findAll();
        return $this->render('film/listeFilm.html.twig' , [
            'lesfilms' => $films
        ]);
    }

       #[Route('/film/{id}', name: 'fichefilm', methods: ['GET'])]

    public function ficheFilms(Flm $film): Response
    {
        return $this->render('film/ficheFilm.html.twig' , [
            'lefilm' => $film
        ]
    
    );
    }
}