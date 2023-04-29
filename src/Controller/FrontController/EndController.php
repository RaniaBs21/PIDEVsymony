<?php

namespace App\Controller\FrontController;

use App\Entity\Admin;
use App\Entity\Points;
use App\Form\PointsType;
use App\Repository\AdminRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EndController extends AbstractController
{

    #[Route('/end', name: 'end')]
    public function dx(ManagerRegistry $doctrine, Request $request, ): Response
    {

        return $this->redirectToRoute('quiz_save_score');


    }

    #[Route('/quiz/saveScore', name: 'quiz_save_score')]
    public function saveScore(Request $request, AdminRepository $adminRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $admin = $this->getUser(); // récupère l'utilisateur connecté
        $points = $entityManager->getRepository(Points::class)->findOneBy(['id' => 1]); // récupère l'objet Points existant avec l'ID 1

        $score = (int) $request->request->get('score'); // Cast to integer

        if (!$points) {
            $points = new Points();
            $points->setId(1);
        }

        $points->setScore($score);
        $new = $points->getScore();

        $entityManager->persist($points);
        $entityManager->flush();

        return $this->render('home_front/end.html.twig', [
            'new'=> $new,
            'score' => $score,
        ]);
    }


}





