<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Form\FiltreAvisType;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAvisController extends AbstractController
{
    #[Route('/admin/avis', name: 'admin_avis_liste')]
    public function liste(AvisRepository $repo, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Formulaire de filtre
        $formFiltreAvis = $this->createForm(FiltreAvisType::class);
        $formFiltreAvis->handleRequest($request);

        $film = null;
        $note = null;
        if ($formFiltreAvis->isSubmitted() && $formFiltreAvis->isValid()) {
            $film = $formFiltreAvis->get('flm')->getData();
            $note = $formFiltreAvis->get('note')->getData();
        }

        $aviss = $repo->findByFilmAndNote($film, $note);

        return $this->render('Admin/avis/AdminlisteAvis.html.twig', [
            'lesaviss' => $aviss,
            'formFiltreAvis' => $formFiltreAvis->createView(),
        ]);
    }

    #[Route('/admin/avis/ajout', name: 'admin_avis_ajout')]
    public function ajout(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($avis);
            $em->flush();

            $this->addFlash('success', 'Avis ajouté 👍');
            return $this->redirectToRoute('admin_avis_liste');
        }

        return $this->render('Admin/avis/AdminformAjoutModifAvis.html.twig', [
            'formAvis' => $form->createView()
        ]);
    }

    #[Route('/admin/avis/modif/{id}', name: 'admin_avis_modif')]
    public function modif(Avis $avis, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Avis modifié ✏️');
            return $this->redirectToRoute('admin_avis_liste');
        }

        return $this->render('Admin/avis/AdminformAjoutModifAvis.html.twig', [
            'formAvis' => $form->createView()
        ]);
    }

    #[Route('/admin/avis/supp/{id}', name: 'admin_avis_supp')]
    public function supp(Avis $avis, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em->remove($avis);
        $em->flush();

        $this->addFlash('danger', 'Avis supprimé 🗑');
        return $this->redirectToRoute('admin_avis_liste');
    }
}
