<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    #[Route('/Avis', name: 'app_Avis')]
    public function index(): Response
    {
        return $this->render('avis/listeAvis.html.twig');
    }
}