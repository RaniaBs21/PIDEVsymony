<?php

namespace App\Controller\FrontController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserLikeController extends AbstractController
{
    #[Route('/user/like', name: 'app_user_like')]
    public function index(): Response
    {
        return $this->render('user_like/index.html.twig', [
            'controller_name' => 'UserLikeController',
        ]);
    }
    
}
