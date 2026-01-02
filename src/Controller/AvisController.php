<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\FiltreAvisType;
use App\Repository\AvisRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'avis', methods: ['GET'])]
    public function listeAvis(AvisRepository $repo, Request $request): Response
    {
        // Formulaire de filtre
        $formFiltreAvis = $this->createForm(FiltreAvisType::class);
        $formFiltreAvis->handleRequest($request);

        $film = null;
        $note = null;
        if ($formFiltreAvis->isSubmitted() && $formFiltreAvis->isValid()) {
            $film = $formFiltreAvis->get('flm')->getData();
            $note = $formFiltreAvis->get('note')->getData();
        }

        // Récupération des avis filtrés
        $aviss = $repo->findByFilmAndNote($film, $note);

        return $this->render('avis/listeAvis.html.twig', [
            'lesaviss' => $aviss,
            'formFiltreAvis' => $formFiltreAvis->createView(),
        ]);
    }

    #[Route('/avis/film/{id}', name: 'avisfilm', methods: ['GET'])]
    public function avisFilm(AvisRepository $repo, int $id): Response
    {
        // Récupère tous les avis pour le film avec id = $id
        $aviss = $repo->findBy(['flms' => $id]);

        return $this->render('avis/listeAvis.html.twig', [
            'lesaviss' => $aviss,
        ]);
    }
}
