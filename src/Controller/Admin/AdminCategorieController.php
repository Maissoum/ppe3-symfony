<?php

namespace App\Controller\Admin;

use App\Entity\Cat;
use App\Form\CatType;
use App\Form\FiltreCatType;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategorieController extends AbstractController
{
    #[Route('/admin/categorie', name: 'admin_categorie_liste')]
    public function liste(CatRepository $repo, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Formulaire de filtre
        $formFiltreCat = $this->createForm(FiltreCatType::class);
        $formFiltreCat->handleRequest($request);

        // Récupération du nom recherché
        $nom = null;
        if ($formFiltreCat->isSubmitted() && $formFiltreCat->isValid()) {
            $nom = $formFiltreCat->get('nom')->getData();
        }

        // Recherche via le repository
        $categories = $repo->findByNom($nom);

        return $this->render('Admin/categorie/AdminlisteCategorie.html.twig', [
            'lesCategories' => $categories,
            'formFiltreCat' => $formFiltreCat->createView(),
        ]);
    }

    #[Route('/admin/categorie/ajout', name: 'admin_categorie_ajout')]
    public function ajout(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($cat);
            $em->flush();

            $this->addFlash('success', 'Catégorie ajoutée 👍');
            return $this->redirectToRoute('admin_categorie_liste');
        }

        return $this->render('Admin/categorie/AdminformAjoutModifCat.html.twig', [
            'formCat' => $form->createView(),
        ]);
    }

    #[Route('/admin/categorie/modif/{id}', name: 'admin_categorie_modif')]
    public function modif(Cat $cat, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Catégorie modifiée ✏️');
            return $this->redirectToRoute('admin_categorie_liste');
        }

        return $this->render('Admin/categorie/AdminformAjoutModifCat.html.twig', [
            'formCat' => $form->createView(),
        ]);
    }

    #[Route('/admin/categorie/supp/{id}', name: 'admin_categorie_supp')]
    public function supp(Cat $cat, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em->remove($cat);
        $em->flush();

        $this->addFlash('danger', 'Catégorie supprimée 🗑');
        return $this->redirectToRoute('admin_categorie_liste');
    }
}
