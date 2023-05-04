<?php

namespace App\Controller\BackendController;

use App\Entity\Cours;
use App\Entity\SousCategorie;
use App\Form\CoursType;
use App\Form\SouscategorieType;
use App\Repository\AbonnementRepository;
use App\Repository\CoursRepository;
use App\Repository\SouscategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SouscategoriesController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function post(): Response
    {
        return $this->render('home_front/basefront.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('home/base.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/evenement', name: 'evenement')]
    public function evenement(): Response
    {
        return $this->render('evenement/components-evenement.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }
    #[Route('/assistance', name: 'assistance')]
    public function assistance(): Response
    {
        return $this->render('assistance/components-assistance.html.twig', [
            'controller_name' => 'AssistanceController',
        ]);
    }
    #[Route('/cours', name: 'cours')]
    public function cours(): Response
    {
        return $this->render('cours/components-cours.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    #[Route('/produit', name: 'produit')]
    public function produit(): Response
    {
        return $this->render('produit/components-produits.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }
    #[Route('/quiz', name: 'quiz')]
    public function quiz(): Response
    {
        return $this->render('quiz/components-quiz.html.twig', [
            'controller_name' => 'QuizController',
        ]);
    }
    #[Route('/user', name: 'user')]
    public function user(): Response
    {
        return $this->render('user/components-user.html.twig', [
            'controller_name' => 'UserController',
        ]);

    }
   
    #[Route('/souscategories', name: 'listScategories')]
    public function listCours(SouscategoriesRepository $souscatrepo): Response
    {
        $souscategorie=$souscatrepo->finAllSouscategories();
        return $this->render('cours/componnents-scategorie.html.twig', [
            'souscategorie' => $souscategorie,
        ]);
    }

    #[Route('/souscategoriess', name: 'listScategoriess')]
    public function listCategories(SouscategoriesRepository $souscatrepo): Response
    {
        $souscategorie=$souscatrepo->finAllSouscategories();
        return $this->render('cours/usercours.html.twig', [
            'souscategories' => $souscategorie,
        ]);
    }

    #[Route('/ajoutScat', name: 'ajoutScat')]
    public function ajoutScat(ManagerRegistry $doctrine, Request $request): Response
    {
        $souscategorie= new SousCategorie;
        $form=$this->createForm(SouscategorieType::class, $souscategorie);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em= $doctrine->getManager();
            $em->persist($souscategorie);
            $em->flush();
            
            // Ajouter un message de succès dans la session
            $this->addFlash('success', 'La sous_categorie a été ajouté avec succès.');
            
            return $this->redirectToRoute('ajoutScat');
        }
        else if ($form->isSubmitted()) {
            $this->addFlash('error', 'Le nom est obligatoire');
        }
    
        return $this->render('cours/ajoutsouscat.html.twig', [
            'formSouscat'=> $form->createView(),
        ]);
    }
    #[Route('/updatesousCategorie/{idSc}', name: 'updatesousCategorie')]
    public function updateScat(Request $request,ManagerRegistry $doctrine,SousCategorie $souscategorie)
    {
        
        $formSouscat=$this->createForm(SouscategorieType::class, $souscategorie);
 
        $formSouscat->handleRequest($request);
 
        if ($formSouscat->isSubmitted()) {
        $em= $doctrine->getManager();
        $entityManager =$doctrine->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('listScategories',['idSc' =>$souscategorie->getIdSc()]);
        }
        return $this->render('cours/updateScat.html.twig', [
            'formSouscat'=> $formSouscat->createView(),
        ]);
    }

    #[Route('/DeleteSoucat/{idSc}', name: 'DeleteSoucat')]
    public function DeleteSoucat($idSc, ManagerRegistry $doctrine): Response
    {
       
        $repoC = $doctrine->getRepository(SousCategorie::class);
        $souscategorie= $repoC->find($idSc);
        $em= $doctrine->getManager();
        $em->remove($souscategorie);
        $em->flush();
        return $this->redirectToRoute('listScategories');
        
    }
    #[Route('/statistiquesc', name:'sous_categorie_par_categorie')]
    public function coursParSousCategorie(SouscategoriesRepository $souscatRepository): Response
{
    $statss = $souscatRepository->countByCategorie();
    $total = array_sum(array_column($statss, 'nbCategorie')); //calculer le total des cours
    
    $statss = array_map(function ($item) use ($total) {
        $item['pourcentage'] = intval(($item['nbCategorie'] / $total) * 100, 2); //calculer le pourcentage
        return $item;
    }, $statss);

    return $this->render('cours/statisticsc.html.twig', [
        'statss' => $statss,
    ]);
}  
  
}