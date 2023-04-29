<?php

namespace App\Controller;

use App\Entity\CategorieCours;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    #[Route('/listcategorie', name: 'listcategorie')]
    public function listCategorie(CategorieRepository $catrepo): Response
    {
        $categorie=$catrepo->finAllcategories();
        return $this->render('categorie/components-categorie.html.twig', [
            'categorie' => $categorie,
        ]);
    }


    
    #[Route('/ajoutcat', name: 'ajoutcat')]
    public function ajoutcat(ManagerRegistry $doctrine, Request $request): Response
    {
        $categorie= new CategorieCours;
        $form=$this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em= $doctrine->getManager();
            $em->persist($categorie);
            $em->flush();
            
            // Ajouter un message de succès dans la session
            $this->addFlash('success', 'La categorie a été ajouté avec succès.');
            
            return $this->redirectToRoute('ajoutcat');
        }
        else if ($form->isSubmitted()) {
            $this->addFlash('error', 'Le nom est obligatoire');
        }
    
        return $this->render('categorie/ajoutcat.html.twig', [
            'formcat'=> $form->createView(),
        ]);
    }

    #[Route('/updateCategorie/{idCat}', name: 'updateCategorie')]
    public function updatecat(Request $request,ManagerRegistry $doctrine,CategorieCours $categorie)
    {
        
        $formcat=$this->createForm(CategorieType::class, $categorie);
 
        $formcat->handleRequest($request);
 
        if ($formcat->isSubmitted()) {
        $em= $doctrine->getManager();
        $entityManager =$doctrine->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('listcategorie',['idCat' =>$categorie->getIdCat()]);
        }
        return $this->render('categorie/updatecat.html.twig', [
            'formcat'=> $formcat->createView(),
        ]);
    }



    #[Route('/Deletecat/{idCat}', name: 'Deletecat')]
    public function Deletecat($idCat, ManagerRegistry $doctrine): Response
    {
       
        $repoC = $doctrine->getRepository(CategorieCours::class);
        $categorie= $repoC->find($idCat);
        $em= $doctrine->getManager();
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('listcategorie');
        
    }
    
}
