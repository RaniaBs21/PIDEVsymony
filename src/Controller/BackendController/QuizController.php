<?php

namespace App\Controller\BackendController;

use App\Entity\Quiz;

use App\Form\QuizType;

use App\Form\UpdateType;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @method getAdmin()
 */
class QuizController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }


    #[Route('/post', name: 'post')]
    public function post(): Response
    {
        return $this->render('post/components-post.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('home/base.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/evenement', name: 'evenement')]
    public function evenement(): Response
    {
        return $this->render('evenement/components-evenement.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }

    #[Route('/assistance', name: 'assistance')]
    public function assistance(): Response
    {
        return $this->render('assistance/components-assistance.html.twig', [
            'controller_name' => 'AssistanceController',
        ]);
    }

    #[Route('/cours', name: 'cours')]
    public function cours(): Response
    {
        return $this->render('cours/components-cours.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    #[Route('/produit', name: 'produit')]
    public function produit(): Response
    {
        return $this->render('produit/components-produits.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }
    #[Route('/quiz', name: 'quiz')]
    public function index(): Response
    {
        return $this->render('quiz/components-quiz.html.twig', [
            'QuizController' => 'QuizController',
        ]);
    }
    #[Route('/afficherQuiz', name: 'read_Quiz')]
    public function read(ManagerRegistry $doctrine, PaginatorInterface $paginator, QuizRepository $quizRepository, Request $request, TranslatorInterface $translator): Response
    {
        $search = $request->query->get('search');
        $sort = $request->query->get('sort');

        if ($search) {
            $quiz = $quizRepository->findBySearch($search);
        } else {
            if ($sort == 'title_asc') {
                $quiz = $quizRepository->findBy([], ['title' => 'desc']);
            } else {
                $quiz = $quizRepository->findAll();
            }
        }

        // Paginer la liste des quiz
        $quizPaginated = $paginator->paginate(
            $quiz,
            $request->query->getInt('page', 1),
            4 // Nombre d'éléments par page
        );

        // Obtenir la locale actuelle
        $locale = $request->getLocale();

        return $this->render('quiz/components-quiz.html.twig', [
            'quiz' => $quizPaginated,
            'title' => $translator->trans('quiz.title', [], 'messages', $locale),
            'description' => $translator->trans('quiz.description', [], 'messages', $locale),
            // Ajouter d'autres clés de traduction ici
        ]);
    }


    #[Route('/new', name: 'ajoutquiz')]
    public function new(Request $request ,ManagerRegistry $doctrine ): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =$doctrine->getManager();
            $em->persist($quiz);
            $em->flush();

            return $this->redirectToRoute('read_Quiz');
        }

        return $this->render('quiz/addQuiz.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/quiz/update/{idQuiz}', name: 'quiz_update')]
    public function update(Request $request, EntityManagerInterface $entityManager, $idQuiz)
    {
        $quiz = $entityManager->getRepository(Quiz::class)->find($idQuiz);

        if (!$quiz) {
            throw $this->createNotFoundException('Quiz non trouvé pour l\'identifiant '.$idQuiz);
        }

        $form = $this->createForm(UpdateType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Quiz mis à jour avec succès!');
            return $this->redirectToRoute('read_Quiz');
        }

        return $this->render('quiz/update.html.twig', [
            'form' => $form->createView(),
            'quiz' => $quiz
        ]);
    }
    #[Route('/delete/{ }', name: 'quiz_delete')]
    public function delete(ManagerRegistry $doctrine,$idQuiz): Response
    {
        $c = $doctrine->getRepository(Quiz::class)->find($idQuiz);
        $em = $doctrine->getManager();
        $em->remove($c);
        $em->flush();
        return $this->redirectToRoute('read_Quiz');
    }
    public function getDetails(Request $request)
    {
        $idQuiz = $request->request->get('idQuiz');
        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($idQuiz);

        $quizDetails= [
            'idQuiz' => $quiz->getIdQuiz(),
            'titre' => $quiz->getTitre(),
            'question'=> $quiz->getQuestion(),
            'option1' => $quiz->getOption1(),
            'option2' => $quiz->getOption2(),
            'option3' => $quiz->getOption3(),
            'option4' => $quiz->getOption4(),
            'reponseCorrecte' => $quiz->getReponseCorrecte(),
        ];
        return new JsonResponse($quizDetails);
    }
    /**
     * @Route("/recherche_ajax", name="recherche_ajax")
     */
    public function rechercheAjax(Request $request, SerializerInterface $serializer,QuizRepository $productRepository): JsonResponse
    {
        $requestString = $request->query->get('searchValue');

        $resultats = $productRepository->findQuizByTitre($requestString);

        if (empty($resultats)) {
            return new JsonResponse(['message' => 'No reclamations found.'], Response::HTTP_OK);
        }

        $data = [];
      foreach ($resultats as $res) {
            $data[] = [
                'titre' => $res->getTitre(),
            ];
        }
        $json = $serializer->serialize($data, 'json', ['groups' => 'reclamations', 'max_depth' => 1]);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
    #[Route('/user', name: 'user')]
    public function user(): Response
    {
        return $this->render('user/components-user.html.twig', [
            'controller_name' => 'UserController',
        ]);

    }
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
        ]);

    }
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);

    }

}
