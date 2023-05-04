<?php
namespace App\Controller\BackendController;
use App\Entity\QuestionQuiz;
use App\Form\QuestionQuizType;
use App\Form\QuestionType;
use App\Form\RechercheType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/question/q')]
class QuestionQController extends AbstractController
{
    #[Route('/', name: 'app_question_q_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $questionQuizzes = $entityManager
            ->getRepository(QuestionQuiz::class)
            ->findAll();

        return $this->render('question_q/index.html.twig', [
            'question_quizzes' => $questionQuizzes,
        ]);
    }

    #[Route('/newQuestion', name: 'app_question_q_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $questionQuiz = new QuestionQuiz();
        $form = $this->createForm(QuestionQuizType::class, $questionQuiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($questionQuiz);
            $entityManager->flush();

            return $this->redirectToRoute('app_question_q_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question_q/new.html.twig', [
            'question_quiz' => $questionQuiz,
            'form' => $form,
        ]);
    }

    #[Route('/{idQuest}', name: 'app_question_q_show', methods: ['GET'])]
    public function show(QuestionQuiz $questionQuiz): Response
    {
        return $this->render('question_q/show.html.twig', [
            'question_quiz' => $questionQuiz,
        ]);
    }

    #[Route('/{idQuest}/edit', name: 'app_question_q_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, QuestionQuiz $questionQuiz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionQuizType::class, $questionQuiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_question_q_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question_q/edit.html.twig', [
            'question_quiz' => $questionQuiz,
            'form' => $form,
        ]);
    }

    #[Route('/{idQuest}', name: 'app_question_q_delete', methods: ['POST'])]
    public function delete(Request $request, QuestionQuiz $questionQuiz, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $questionQuiz->getIdQuest(), $request->request->get('_token'))) {
            $entityManager->remove($questionQuiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_question_q_index', [], Response::HTTP_SEE_OTHER);
    }

#[Route('/question_quiz/search', name: 'search_question_quiz' ,methods: ['GET', 'POST'])]


    public function searchQuestionQuiz(Request $request, QuestionRepository $questionRepository)
    {
        $searchTerm = $request->query->get('search');

        // Vérifier que le terme de recherche n'est pas vide
        if (!$searchTerm) {
            return $this->redirectToRoute('home');
        }

        // Rechercher les questions correspondantes dans le référentiel de question
        $questionQuizList = $questionRepository->createQueryBuilder('q')
            ->where('q.descQuestion LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();

        return $this->render('question_q/find.html.twig', [
            'searchTerm' => $searchTerm,
            'questionQuizList' => $questionQuizList,


        ]);
    }


}




