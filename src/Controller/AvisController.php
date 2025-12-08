<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'avis', methods: ['GET'])]
    public function listeAvis(AvisRepository $repo): Response
    {
        $aviss = $repo->findAll();

        return $this->render('avis/listeAvis.html.twig', [
            'lesaviss' => $aviss
        ]);
    }

    #[Route('/Avis/film/{id}', name: 'avisfilm', methods: ['GET'])]
    public function avisFilm(AvisRepository $repo, int $id): Response
    {
        // Récupère tous les avis pour le film avec id = $id
        $aviss = $repo->findBy(['flms' => $id]);

        return $this->render('avis/listeAvis.html.twig', [
            'lesaviss' => $aviss
        ]);
    }
}
