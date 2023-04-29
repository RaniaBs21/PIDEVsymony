<?php

namespace App\Controller\FrontController;

use App\Entity\Points;
use App\Entity\QuestionQuiz;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method getRequest()
 */
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
        $resultsPerPage = 10;
        $currentPage = $request->query->getInt('page', 1);

        $quizs = $em->getRepository(Quiz::class)
            ->createQueryBuilder('q')
            ->setFirstResult(($currentPage - 1) * $resultsPerPage)
            ->setMaxResults($resultsPerPage)
            ->getQuery()
            ->getResult();

        $totalQuizs = $em->getRepository(Quiz::class)
            ->createQueryBuilder('q')
            ->select('COUNT(q.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $score = (int) $request->request->get('score'); // Cast to integer

        $new = new Points();
        $new->setScore($score);

        $totalPages = ceil($totalQuizs / $resultsPerPage);

        return $this->render('home_front/quiz.html.twig', [
            'quizs' => $quizs,
            'new'=> $score,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ]);
    }



}
