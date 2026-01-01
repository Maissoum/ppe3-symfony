<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAvisController extends AbstractController
{
    #[Route('/admin/avis', name: 'admin_avis_liste')]
    public function liste(AvisRepository $repo): Response
    {
        return $this->render('avis/AdminlisteAvis.html.twig', [
            'lesaviss' => $repo->findAll()
        ]);
    }

    #[Route('/admin/avis/ajout', name: 'admin_avis_ajout')]
    public function ajout(Request $request, EntityManagerInterface $em): Response
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($avis);
            $em->flush();

            // Message flash ajouté avant redirection
            $this->addFlash('success', 'Avis ajouté 👍');

            // Redirection vers la liste pour afficher le message
            return $this->redirectToRoute('admin_avis_liste');
        }

        return $this->render('avis/AdminformAjoutModifAvis.html.twig', [
            'formAvis' => $form->createView()
        ]);
    }

    #[Route('/admin/avis/modif/{id}', name: 'admin_avis_modif')]
    public function modif(Avis $avis, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AvisType::class, $avis);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Avis modifié ✏️');
            return $this->redirectToRoute('admin_avis_liste');
        }

        return $this->render('avis/AdminformAjoutModifAvis.html.twig', [
            'formAvis' => $form->createView()
        ]);
    }

    #[Route('/admin/avis/supp/{id}', name: 'admin_avis_supp')]
    public function supp(Avis $avis, EntityManagerInterface $em): Response
    {
        $em->remove($avis);
        $em->flush();

        $this->addFlash('danger', 'Avis supprimé 🗑');
        return $this->redirectToRoute('admin_avis_liste');
    }
}
