<?php

namespace App\Controller\BackendController;

use App\Entity\Cours;
use App\Entity\SousCategorie;
use App\Form\CoursType;
use App\Repository\AbonnementRepository;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class HomecoursController extends AbstractController
{

    #[Route('/frontcours', name: 'frontcours')]
    public function listCours(CoursRepository $coursrepo): Response
    {
        $cour = $coursrepo->findAll();
        $imageNameArray = array();
        foreach ($cour as $cours) {
            array_push($imageNameArray, $cours->getImageName());
        }
        return $this->render('cours/usercours.html.twig', [
            'cour' => $cour,
            'imageNameArray' => $imageNameArray
        ]);
    }
    


   
    
}

