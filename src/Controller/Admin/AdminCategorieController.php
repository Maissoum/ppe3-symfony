<?php

namespace App\Controller\Admin;

use App\Entity\Cat;
use App\Form\CatType;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategorieController extends AbstractController
{
    #[Route('/admin/categorie', name: 'admin_categorie_liste')]
    public function liste(CatRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('categorie/AdminlisteCategorie.html.twig', [
            'lesCategories' => $repo->findAll()
        ]);
    }

    #[Route('/admin/categorie/ajout', name: 'admin_categorie_ajout')]
    public function ajout(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($cat);
            $em->flush();

            $this->addFlash("success", "Catégorie ajoutée 👍");
            return $this->redirectToRoute('admin_categorie_liste');
        }

        return $this->render('categorie/AdminformAjoutModifCat.html.twig', [
            'formCat' => $form->createView()
        ]);
    }

    #[Route('/admin/categorie/modif/{id}', name: 'admin_categorie_modif')]
    public function modif(Cat $cat, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(CatType::class, $cat);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();

            $this->addFlash("success", "Catégorie modifiée ✏️");
            return $this->redirectToRoute('admin_categorie_liste');
        }

        return $this->render('categorie/AdminformAjoutModifCat.html.twig', [
            'formCat' => $form->createView()
        ]);
    }

    #[Route('/admin/categorie/supp/{id}', name: 'admin_categorie_supp')]
    public function supp(Cat $cat, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em->remove($cat);
        $em->flush();

        $this->addFlash("danger", "Catégorie supprimée 🗑");
        return $this->redirectToRoute('admin_categorie_liste');
    }
}
