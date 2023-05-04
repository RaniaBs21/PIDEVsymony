<?php

namespace App\Controller\BackendController;

use App\Entity\LevelCours;
use App\Form\LevelType;
use App\Repository\LevelRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LevelController extends AbstractController
{
    #[Route('/level', name: 'app_level')]
    public function index(): Response
    {
        return $this->render('level/index.html.twig', [
            'controller_name' => 'LevelController',
        ]);
    }



    #[Route('/listlevel', name: 'listlevel')]
    public function listLevel(LevelRepository $catrepo): Response
    {
        $level=$catrepo->finAllLevel();
        return $this->render('level/components-level.html.twig', [
            'level' => $level,
        ]);
    }


    
    #[Route('/ajoutlevel', name: 'ajoutlevel')]
    public function ajoutcat(ManagerRegistry $doctrine, Request $request): Response
    {
        $level= new LevelCours;
        $form=$this->createForm(LevelType::class, $level);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em= $doctrine->getManager();
            $em->persist($level);
            $em->flush();
            
            // Ajouter un message de succès dans la session
            $this->addFlash('success', 'Le niveau a été ajouté avec succès.');
            
            return $this->redirectToRoute('ajoutlevel');
        }
        else if ($form->isSubmitted()) {
            $this->addFlash('error', 'Le nom est obligatoire');
        }
    
        return $this->render('level/ajoutlevel.html.twig', [
            'formlevel'=> $form->createView(),
        ]);
    }

    #[Route('/updateLevel/{idLevel}', name: 'updateLevel')]
    public function updatelevel(Request $request,ManagerRegistry $doctrine,LevelCours $level)
    {
        
        $formlevel=$this->createForm(LevelType::class, $level);
 
        $formlevel->handleRequest($request);
 
        if ($formlevel->isSubmitted()) {
        $em= $doctrine->getManager();
        $entityManager =$doctrine->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('listlevel',['idLevel' =>$level->getIdLevel()]);
        }
        return $this->render('level/updatelevel.html.twig', [
            'formlevel'=> $formlevel->createView(),
        ]);
    }



    #[Route('/deletelevel/{idLevel}', name: 'deletelevel')]
    public function Deletelevel($idLevel, ManagerRegistry $doctrine): Response
    {
       
        $repoC = $doctrine->getRepository(LevelCours::class);
        $level= $repoC->find($idLevel);
        $em= $doctrine->getManager();
        $em->remove($level);
        $em->flush();
        return $this->redirectToRoute('listlevel');
        
    }
}
