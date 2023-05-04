<?php

namespace App\Controller\BackendController;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit/services')]
class ProduitServicesController extends AbstractController
{
    #[Route('/', name: 'app_produit_services_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager
            ->getRepository(Produit::class)
            ->findAll();

        return $this->render('produit_services/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/new', name: 'app_produit_services_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the uploaded file
            $file = $form['url']->getData();
    
            // Generate a unique filename for the file
            $fileName = uniqid().'.'.$file->guessExtension();
    
            // Move the file to a permanent location on your server
            $file->move(
                $this->getParameter('public_img'),
                $fileName
            );
    
            // Update the Produit object with the file path
            $produit->seturl($fileName);
    
            // Persist and flush the Produit object to your database
            $entityManager->persist($produit);
            $entityManager->flush();
    
            // Redirect to the list of produits
            return $this->redirectToRoute('app_produit_services_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('produit_services/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{idProd}', name: 'app_produit_services_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit_services/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{idProd}/edit', name: 'app_produit_services_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit_services/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{idProd}', name: 'app_produit_services_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getIdProd(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_services_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/produit/rechercher', name: 'app_produit_rechercher', methods: ['POST'])]
    public function rechercher(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $nom = $request->request->get('type');  
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('p')
            ->from(Produit::class, 'p')
            ->where('p.typeProd LIKE :type') 
            ->setParameter('type', '%'.$nom.'%') 
            ->orderBy('p.typeProd', 'ASC'); 
        $produits = $queryBuilder->getQuery()->getResult();



    $produitsArray = []; 
    foreach ($produits as $produit) {
        $produitsArray[] = [
            'idProd' => $produit->getIdProd(),
            'idCatProd' => $produit->getIdCatProd(), 
            'typeProd' => $produit->getTypeProd(), 
            'descriptionProd' => $produit->getDescriptionProd(), 
            'prixProd' => $produit->getPrixProd(),
            'url' => $produit->getUrl()
        ];
        }

        
        return new JsonResponse([
            'produits' => $produitsArray,
        ]);
    }
}
