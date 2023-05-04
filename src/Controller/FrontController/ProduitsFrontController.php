<?php

namespace App\Controller\FrontController;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class ProduitsFrontController extends AbstractController
{
    #[Route('/produits/front', name: 'app_produits_front')]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator,HttpFoundationRequest $request): Response
    { //$produit = $entityManager
        //->getRepository(Produit::class)
        //->findAll();
        $queryBuilder = $entityManager
        ->getRepository(Produit::class)
        ->createQueryBuilder('p')
        ->getQuery();

    $pagination = $paginator->paginate(
        $queryBuilder,
        $request->query->getInt('page', 1),
        4
    
    );
        return $this->render('home_front/ProduitsFront.html.twig', [
            'controller_name' => 'ProduitsFrontController',
            'produits' => $pagination,
        ]);
    }

}