<?php

namespace App\Controller\FrontController;

use App\Entity\Commentaire;
use App\Entity\Likee;
use App\Form\CommentaireFrontType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UserCommentaireController extends AbstractController
{
    #[Route('/user/post/commentaire', name: 'app_user_commentaire')]
    public function listCommentaire(ManagerRegistry $doctrine): Response
    {
        $Commentairerepository=$doctrine->getRepository(Commentaire::class);
        $commentaires=$Commentairerepository->findAll();
        return $this->render('user_commentaire/afficherComUser.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }


    #[Route('/user/post/commentaire/new', name: 'new_comment', methods: ['GET', 'POST'])]
        public function newComment(Request $request, EntityManagerInterface $entityManager): Response
        {
            $commentaire = new Commentaire();
            $form = $this->createForm(CommentaireFrontType::class, $commentaire);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash('success', 'Votre commentaire est bien ajouté ');
                $entityManager->persist($commentaire);
                $entityManager->flush();
               
                return $this->redirectToRoute('app_user_commentaire', [], Response::HTTP_SEE_OTHER);
            }
            return $this->renderForm('user_commentaire/addCom.html.twig', [
                'commentaire' => $commentaire,
                'form' => $form,
            ]);
        }

       
}
