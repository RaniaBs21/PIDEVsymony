<?php

namespace App\Controller\BackendController;

use App\Entity\ReponseQuiz;
use App\Form\ReponseQuizType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reponse/q')]
class ReponseQController extends AbstractController
{
    #[Route('/', name: 'app_reponse_q_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reponseQuizzes = $entityManager
            ->getRepository(ReponseQuiz::class)
            ->findAll();

        return $this->render('reponse_q/index.html.twig', [
            'reponse_quizzes' => $reponseQuizzes,
        ]);
    }

    #[Route('/new', name: 'app_reponse_q_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reponseQuiz = new ReponseQuiz();
        $form = $this->createForm(ReponseQuizType::class, $reponseQuiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponseQuiz);
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_q_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_q/new.html.twig', [
            'reponse_quiz' => $reponseQuiz,
            'form' => $form,
        ]);
    }

    #[Route('/{idRep}', name: 'app_reponse_q_show', methods: ['GET'])]
    public function show(ReponseQuiz $reponseQuiz): Response
    {
        return $this->render('reponse_q/show.html.twig', [
            'reponse_quiz' => $reponseQuiz,
        ]);
    }

    #[Route('/{idRep}/edit', name: 'app_reponse_q_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReponseQuiz $reponseQuiz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseQuizType::class, $reponseQuiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_q_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_q/edit.html.twig', [
            'reponse_quiz' => $reponseQuiz,
            'form' => $form,
        ]);
    }

    #[Route('/{idRep}', name: 'app_reponse_q_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseQuiz $reponseQuiz, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseQuiz->getIdRep(), $request->request->get('_token'))) {
            $entityManager->remove($reponseQuiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_q_index', [], Response::HTTP_SEE_OTHER);
    }
}
