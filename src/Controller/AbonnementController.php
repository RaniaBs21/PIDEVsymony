<?php

namespace App\Controller;

use App\Repository\AbonnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbonnementController extends AbstractController
{
    #[Route('/abonnement', name: 'app_abonnement')]
    public function index(): Response
    {
        return $this->render('abonnement/index.html.twig', [
            'controller_name' => 'AbonnementController',
        ]);
    }
        
    #[Route('/listabonnement', name: 'listAbonnement')]
    public function listCours(AbonnementRepository $abonrepo): Response
    {
        $abonnement=$abonrepo->finAllabon();
        return $this->render('abonnement/componnents-abonn.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }
}
