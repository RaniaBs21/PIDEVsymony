<?php

namespace App\Controller\BackendController;

use App\Entity\Cours;
use App\Entity\SousCategorie;
use App\Form\CoursType;
use App\Repository\AbonnementRepository;
use App\Repository\CoursRepository;
use App\Repository\SouscategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Prdh\RecaptchaBundle\Validator\Constraints\Recaptcha;
use Psr\Log\LoggerInterface;
use ReCaptcha\ReCaptcha as ReCaptchaReCaptcha;
use VictorPrdh\RecaptchaBundle\RecaptchaBundle;



class CoursController extends AbstractController

{
    public function __construct(private LoggerInterface $logger, private SerializerInterface $serializer)
    {

    }
    #[Route('/post', name: 'post')]
    public function post(): Response
    {
        return $this->render('home_front/basefront.html.twig', [
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
    public function quiz(): Response
    {
        return $this->render('quiz/components-quiz.html.twig', [
            'controller_name' => 'QuizController',
        ]);
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

    #[Route('/cours', name: 'listCours')]
    public function listCours(CoursRepository $coursrepo): Response
    {
        $cour=$coursrepo->finAllCours();
        return $this->render('cours/components-cours.html.twig', [
            'cour' => $cour,
        ]);
    }
 
   /* #[Route('/ajoutcours', name: 'ajoutcours')]
    public function ajout(ManagerRegistry $doctrine, Request $request, Recaptcha $recaptcha): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {
            // Valider le recaptcha
            $errors = $this->get('validator')->validate($request->request->get('recaptcha_response'), $recaptcha);
            if (count($errors) === 0) {
            $em = $doctrine->getManager();
    
            // Ajoutez ce code pour gérer l'upload de l'image
            $imageFile = $form->get('fichierC')->getData();
            if ($imageFile) {
                $imageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $imageName.'-'.uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $cours->setImageName($newFilename);
            }
            
            $em->persist($cours);
            $em->flush();
    
            // Ajouter un message de succès dans la session
            $this->addFlash('success', 'Le cours a été ajouté avec succès.');
    
            return $this->redirectToRoute('ajoutcours');
         } else {
                // Gérer les erreurs de recaptcha
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }
        } else if ($form->isSubmitted()) {
            $this->addFlash('error', 'Le titre est obligatoire');
        }
    
        return $this->render('cours/ajoutcours.html.twig', [
            'formCours' => $form->createView(),
            'imageName' => $cours->getImageName(),
        ]);
    }*/
    




    #[Route('/ajoutcours', name: 'ajoutcours')]
    public function ajout(ManagerRegistry $doctrine, Request $request): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
    
            // Ajoutez ce code pour gérer l'upload de l'image
            $imageFile = $form->get('fichierC')->getData();
            if ($imageFile) {
                $imageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $imageName.'-'.uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $cours->setImageName($newFilename);
            }
            
            $em->persist($cours);
            $em->flush();
    
            // Ajouter un message de succès dans la session
            $this->addFlash('success', 'Le cours a été ajouté avec succès.');
    
            return $this->redirectToRoute('ajoutcours');
        } else if ($form->isSubmitted()) {
            $this->addFlash('error', 'Le titre est obligatoire');
        }
    
        return $this->render('cours/ajoutcours.html.twig', [
            'formCours' => $form->createView(),
            'imageName' => $cours->getImageName(),
        ]);
    }
    






  /*     #[Route('/modifeCours/{idC}', name: 'updatedCours')]
    public function updateCours(Request $request,ManagerRegistry $doctrine,Cours $cours)
    {
        
        $formCours=$this->createForm(CoursType::class, $cours);
 
        $formCours->handleRequest($request);
 
        if ($formCours->isSubmitted()) {
        $em= $doctrine->getManager();
        $entityManager =$doctrine->getManager();
        $entityManager->flush();
        
        return $this->redirectToRoute('listCours',['idC' =>$cours->getIdC()]);
        }
        return $this->render('cours/updatecours.html.twig', [
            'formCours'=> $formCours->createView(),
            'cours'=>$cours
        ]);
    }*/
    








    #[Route('/modifeCours/{idC}', name: 'updatedCours')]

     public function updateCours(Request $request, ManagerRegistry $doctrine, Cours $cours)
     {
         $formCours = $this->createForm(CoursType::class, $cours, ['cours' => $cours]);
         
         $formCours->handleRequest($request);
         
         // Récupérer la valeur sélectionnée du champ "SousCategorie"
         $sousCategorie = $formCours->get('SousCategorie')->getData();
         
         if ($formCours->isSubmitted() && $formCours->isValid()) {
             $entityManager = $doctrine->getManager();
     
             $file = $formCours->get('fichierC')->getData();
             
             if ($file) {
                 $fileName = uniqid().'.'.$file->guessExtension();
     
                 $file->move(
                     $this->getParameter('cours_directory'),
                     $fileName
                 );
     
                 $cours->setFichierC($fileName);
             }
     
             $entityManager->flush();
     
             return $this->redirectToRoute('listCours', ['idC' => $cours->getIdC()]);
         }
     
         return $this->render('cours/updatecours.html.twig', [
             'formCours' => $formCours->createView(),
             'cours' => $cours,
         ]);
     }

     
     
 #[Route('delete/{idC}', name: 'deleteCours')]
 public function DeleteSoucat($idC, ManagerRegistry $doctrine): Response
 {
  
    $repoCours = $doctrine->getRepository(Cours::class);
    $cours= $repoCours->find($idC);
    $em= $doctrine->getManager();
    $em->remove($cours);
    $em->flush();

    return $this->redirectToRoute('listCours');
    
}

#[Route('/detailscours/{idC}/{imageName}', name: 'detailscours')]
public function show($idC, $imageName, ManagerRegistry $doctrine): Response
{   
    $repoC = $doctrine->getRepository(Cours::class);
    $cour= $repoC->find($idC);
    return $this->render('cours/savoirplus.html.twig', [
        'cour' => $cour,
        'imageName' => $imageName
    ]);
}

   #[Route('/recherche_ajax', name:'recherche_ajax')]
    
        public function rechercheAjax(Request $request, SerializerInterface $serializer,CoursRepository $courRepository): JsonResponse
        {
            $requestString = $request->query->get('searchValue');

            $resultats = $courRepository->findCoursByTitre($requestString);

            if (empty($resultats)) {
                return new JsonResponse(['message' => 'No cours found.'], Response::HTTP_OK);
            }
            
            $data = [];

            foreach ($resultats as $res) {
                $data[] = [
                    'titreC' => $res->getTitreC(),
                    'sousCategorie' => $res->getSousCategorie(),
                    'niveauC' => $res->geNiveauC(),
                    'descriptionC' => $res->getDescriptionC(),
                    'dateC' => $res->getDateC(),
                    'prix' => $res->getPrix(),

                    ];
            }

            $json = $serializer->serialize($data, 'json', ['groups' => 'cours', 'max_depth' => 1]);

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

     /*   /**
     * @throws ExceptionInterface
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
      /*  #[Route('/search', name: 'courSearch')]
        public function searchAction(Request $request, CoursRepository $courRepository): Response
        {
            $searchTerm = $request->query->get('query');
    
            $cours = $courRepository->findByCritere($searchTerm);
    
            $jsonContent = $this->serializer->serialize($cours, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getIdC();
                }
            ]);
    
            return new Response($jsonContent);
        }*/


}
