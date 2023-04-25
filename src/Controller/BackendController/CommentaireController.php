<?php

namespace App\Controller\BackendController;

use App\Entity\Commentaire;
use App\Entity\Likee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

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

   /* #[Route('/post/sujet/commentaire/{idcom}/like', name: 'comment_like', methods: ['POST'])]
    public function like(Request $request, Commentaire $commentaire): Response
    {
        $type = $request->request->get('type', 'likee');
        $entityManager = $this->getDoctrine()->getManager();

        $existingLike = $entityManager->getRepository(Likee::class)->findOneBy([
            'commentaire' => $commentaire,
            'type' => $type,
        ]);

        if ($existingLike) {
            $entityManager->remove($existingLike);
            if ($type === 'likee') {
                $commentaire->setNblike($commentaire->getNblike() - 1);
            } else {
                $commentaire->setNbdislike($commentaire->getNbdislike() - 1);
            }
        } else {
            $like = new Likee();
            $like->setType($type);
            $like->setIdCommentaire($commentaire);
            $entityManager->persist($like);
            if ($type === 'likee') {
                $commentaire->setNblike($commentaire->getNblike() + 1);
            } else {
                $commentaire->setNbdislike($commentaire->getNbdislike() + 1);
            }
        }

        $entityManager->flush();

        return $this->redirectToRoute('listcom', [
            'id' => $commentaire->getIdcom()]
        );
        

    }*/
}



