<?php

namespace App\Controller\FrontController;

use App\Entity\Points;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController
{
    #[Route('/result', name: 'result')]
    public function dx(): Response
    {
        return $this->render('home_front/result.html.twig', [
            'controller_name' => 'EndFrontController',
        ]);
    }
}