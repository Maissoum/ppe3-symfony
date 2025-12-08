<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Repository\AbonnementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbonnementController extends AbstractController
{
    #[Route('/abonnement', name: 'abonnement', methods: ['GET'])]
    public function listeAbonnement(AbonnementRepository $repo): Response
    {
        $abonnements = $repo->findAll();

        return $this->render('abonnement/listeAbonnement.html.twig', [
            'lesabonnements' => $abonnements
        ]);
    }

    #[Route('/abonnement/{id}', name: 'ficheabonnement', methods: ['GET'])]
    public function ficheAbonnement(Abonnement $abonnement): Response
    {
        return $this->render('abonnement/ficheAbonnement.html.twig', [
            'leabonnement' => $abonnement
        ]);
    }
}
