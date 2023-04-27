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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface ;

class HomecoursController extends AbstractController
{

    /*#[Route('/frontcours', name: 'frontcours')]
    public function listCours(CoursRepository $coursrepo, SouscategoriesRepository $souscatrepo, PaginatorInterface $paginator, Request $request): Response
    {
        $cour = $coursrepo->findAll();
        $souscategories=$souscatrepo->finAllSouscategories();
        
        // Paginer la liste de cours
        $courPaginated = $paginator->paginate(
            $cour,
            $request->query->getInt('page', 1),
            3 // Nombre d'éléments par page
        );

        return $this->render('cours/usercours.html.twig', [
            'souscategories' => $souscategories,
            'cour' => $courPaginated
        ]);
    }*/


#[Route('/frontcours', name: 'frontcours')]
public function listCours(CoursRepository $coursrepo, SouscategoriesRepository $souscatrepo, PaginatorInterface $paginator, Request $request): Response
{
    $idSousCategorie = $request->query->get('idSousCategorie');

    // Si l'ID de la sous-catégorie est défini, récupérez les cours correspondants
    if ($idSousCategorie) {
        $cour = $coursrepo->findBySousCategorie($idSousCategorie);
    } else {
        $cour = $coursrepo->findAll();
    }

    $cour = $coursrepo->findAll();
    $souscategories=$souscatrepo->finAllSouscategories();

    // Paginer la liste de cours
    $courPaginated = $paginator->paginate(
        $cour,
        $request->query->getInt('page', 1),
        3 // Nombre d'éléments par page
    );

    return $this->render('cours/usercours.html.twig', [
        'souscategories' => $souscategories,
        'cour' => $courPaginated
    ]);
}


 /*#[Route('/search-courses', name: 'search_courses', options: ["expose" => true])]
public function searchCourses(Request $request, CoursRepository $coursRepository)
{
    $titreC = $request->query->get('titreC');
    $courses = $coursRepository->findCoursesByTerm($titreC);

    $data = [];
    foreach ($courses as $course) {
        $data[] = [
            'id' => $course->getIdC(),
            'label' => $course->getTitreC(),
            'value' => $course->getTitreC(),
        ];
    }

    return new JsonResponse($data);
}*/


#[Route('/frontcours/{souscategorie}', name: 'frontcours')]
public function listCoursS(CoursRepository $coursrepo, SouscategoriesRepository $souscatrepo, PaginatorInterface $paginator, Request $request, $souscategorie = null): Response
{
    $souscategories=$souscatrepo->finAllSouscategories();
    $selectedSousCategorie = $souscatrepo->findOneBy(['nomSc' => $souscategorie]);
    
    if ($selectedSousCategorie) {
        $cour = $coursrepo->findBySousCategorie($selectedSousCategorie->getIdSc());
    } else {
        $cour = $coursrepo->finAllCours();
    }

    // Paginer la liste de cours
    $courPaginated = $paginator->paginate(
        $cour,
        $request->query->getInt('page', 1),
        3 // Nombre d'éléments par page
    );

    return $this->render('cours/usercours.html.twig', [
        'souscategories' => $souscategories,
        'selectedSousCategorie' => $selectedSousCategorie,
        'cour' => $courPaginated
    ]);
}


    
}

