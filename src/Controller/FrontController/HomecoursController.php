<?php

namespace App\Controller\FrontController;

use App\Entity\Cours;
use App\Repository\CoursRepository;
use App\Repository\SouscategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface ;
use Symfony\Component\CssSelector\XPath\TranslatorInterface as XPathTranslatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;



class HomecoursController extends AbstractController
{



#[Route('/frontcours', name: 'frontcours')]
public function listCours(CoursRepository $coursrepo, SouscategoriesRepository $souscatrepo, PaginatorInterface $paginator, Request $request): Response
{
    $idSousCategorie = $request->query->get('idSousCategorie');
    $cour = $coursrepo->findAllOrderedByTitle();
    // Si l'ID de la sous-catégorie est défini, récupérez les cours correspondants
    if ($idSousCategorie) {
       
        $cour = $coursrepo->findBySousCategorie($idSousCategorie);
    } else {
        $cour = $coursrepo->findAllOrderedByTitle();
    }

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



#[Route('/frontcours/{souscategorie}', name: 'frontcours')]
public function listCoursS(CoursRepository $coursrepo, SouscategoriesRepository $souscatrepo, PaginatorInterface $paginator, Request $request, $souscategorie = null): Response
{
    $cour = $coursrepo->findAllOrderedByTitle();
    $souscategories=$souscatrepo->finAllSouscategories();
    $selectedSousCategorie = $souscatrepo->findOneBy(['nomSc' => $souscategorie]);
    
    if ($selectedSousCategorie) {
        $cour = $coursrepo->findBySousCategorie($selectedSousCategorie->getIdSc());
    } else {
        $cour = $coursrepo->findAllOrderedByTitle();
    }

    // Paginer la liste de cours
    $courPaginated = $paginator->paginate(
        $cour,
        $request->query->getInt('page', 1),
        4 // Nombre d'éléments par page
    );

    return $this->render('cours/usercours.html.twig', [
        'souscategories' => $souscategories,
        'selectedSousCategorie' => $selectedSousCategorie,
        'cour' => $courPaginated
    ]);
}

    /**
     * @Route("/translate", name="translate")
     */
    public function translate(TranslatorInterface $translator)
    {
        $description = $translator->trans('cours.descriptionC', [], 'messages', 'en');
        return new JsonResponse(['description' => $description]);
    }
}

