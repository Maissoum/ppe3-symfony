<?php

namespace App\Controller\Admin;

use App\Entity\Flm;
use App\Form\FlmType;
use App\Repository\FlmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminFilmController extends AbstractController
{
    #[Route('/admin/film', name: 'admin_film_liste')]
    public function liste(FlmRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('film/AdminlisteFilm.html.twig', [
            'lesFilms' => $repo->findAll()
        ]);
    }

    #[Route('/admin/film/ajout', name: 'admin_film_ajout')]
    public function ajout(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $film = new Flm();
        $form = $this->createForm(FlmType::class, $film);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($film);
            $em->flush();

            $this->addFlash("success", "Film ajouté 🎬");
            return $this->redirectToRoute('admin_film_liste');
        }

        return $this->render('film/AdminformAjoutModifFilm.html.twig', [
            'formFilm' => $form->createView()
        ]);
    }

    #[Route('/admin/film/modif/{id}', name: 'admin_film_modif')]
    public function modif(Flm $film, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(FlmType::class, $film);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash("success", "Film modifié ✏️");
            return $this->redirectToRoute('admin_film_liste');
        }

        return $this->render('film/AdminformAjoutModifFilm.html.twig', [
            'formFilm' => $form->createView()
        ]);
    }

    #[Route('/admin/film/supp/{id}', name: 'admin_film_supp')]
    public function supp(Flm $film, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em->remove($film);
        $em->flush();

        $this->addFlash("danger", "Film supprimé 🗑");
        return $this->redirectToRoute('admin_film_liste');
    }
}
