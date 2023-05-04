<?php


namespace App\Controller\FrontController;

use App\Entity\Points;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeFrontController extends AbstractController
{
    #[Route('/home/front', name: 'app_home_front')]
    public function index(): Response
    {
        return $this->render('home_front/basefront.html.twig', [
            'controller_name' => 'HomeFrontController',
        ]);
    }

    #[Route('/index', name: 'app_index')]
    public function c(): Response
    {
        return $this->render('home_front/index.html.twig', [
            'controller_name' => 'HomeFrontController',
        ]);
    }
    
    #[Route('/quiz', name: 'quiz')]
    public function play(Request $request, EntityManagerInterface $em): Response
    {
        return $this->render('home_front/quiz.html.twig', [
            'controller_name' => 'HomeFrontController',
        ]);
    }


}
