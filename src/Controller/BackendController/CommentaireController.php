<?php

namespace App\Controller\BackendController;

use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class CommentaireController extends AbstractController
{
    #[Route('/post/sujet/commentaire', name: 'listcom')]
    public function listCommentaire(ManagerRegistry $doctrine): Response
    {
        $Commentairerepository=$doctrine->getRepository(Commentaire::class);
        $commentaires=$Commentairerepository->findAll();
        return $this->render('commentaire/afficherCom.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }
}
