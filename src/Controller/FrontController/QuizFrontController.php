<?php

namespace App\Controller\FrontController;

use App\Entity\Points;
use App\Entity\QuestionQuiz;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizFrontController extends AbstractController
{



#[Route('/quiz/userHighScore/{Id}', name: 'quiz_user_high_score')]

    public function getUserHighScore(int $Id, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Points::class);
        $query = $repository->createQueryBuilder('s')
            ->select('MAX(s.score) as highScore')
            ->where('s.id = :Id')
            ->setParameter('Id', $Id)
            ->getQuery();

        $highScore = $query->getSingleScalarResult();

        return $this->render('quiz/result.html.twig', ['highScore' => $highScore]);
    }




    #[Route('/play', name: 'app_quiz')]
    public function play(): Response
    {

        return $this->redirectToRoute('quiz');
    }
    #[Route('/end', name: 'app_end')]
    public function end(): Response
    {
        return $this->render('home_front/end.html.twig', [
            'controller_name' => 'HomeFrontController',
        ]);
    }

    #[Route('/resultat', name: 'app_result')]
    public function resultat(): Response
    {
     return $this->redirectToRoute('result');
    }
    #[Route('/front', name: 'front_question')]
    public function quizAction(): Response
    {
        $question_quizzes= $this->getDoctrine()->getRepository(QuestionQuiz::class)->findAll();
        return $this->render('home_front/index1.html.twig', [
            'question_quizzes' => $question_quizzes,

        ]);
    }
    #[Route('/recherche', name: 'app_search')]
    public function recherche(): Response
    {
        return $this->redirectToRoute('search_question_quiz');
    }


}