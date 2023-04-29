<?php

namespace App\Controller\FrontController;

use App\Entity\Post;
use App\Form\PostFrontType;
use App\Repository\BadWordsFilter;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;



class UserPostController extends AbstractController
{


    #[Route('/user/post', name: 'app_user_post')]
    public function listPost( PostRepository $postrepo , PaginatorInterface $paginator, Request $request): Response
    {
        $post = $postrepo->findAll();
        
        // Paginer la liste des quiz
        $postPaginated = $paginator->paginate(
            $post,
            $request->query->getInt('page', 1),
            4 // Nombre d'éléments par page
        );

        return $this->render('user_post/index.html.twig', [
            'post' => $postPaginated,
            
        ]);
    }
   
    #[Route('/user/post/new', name: 'new_post', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostFrontType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the uploaded file
            $file = $form['image']->getData();

            // Generate a unique filename for the file
            $fileName = uniqid().'.'.$file->guessExtension();

            // Move the file to a permanent location on your server
            $file->move(
                $this->getParameter('public_img'),
                $fileName
            );

            // Update the Produit object with the file path
            $post->setImage($fileName);

            // Persist and flush the Produit object to your database
            $entityManager->persist($post);
            $entityManager->flush();
            
            $this->addFlash('success', 'Votre Post est bien ajouté ');

            // Redirect to the list of produits
            return $this->redirectToRoute('app_user_post', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_post/addpost.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }
        
        #[Route('/user/post/{idpost}', name: 'app_post_front_show')]
        public function showpost(Post $post): Response
        {
            return $this->render('user_post/showPost.html.twig', [
                'post' => $post,
            ]);
        }

        #[Route('/user/post/{idpost}', name: 'app_postfront_delete', methods: ['POST'])]
        public function deletepost(Request $request, Post $post, EntityManagerInterface $entityManager): Response
        {
            if ($this->isCsrfTokenValid('delete'.$post->getIdpost(), $request->request->get('_token'))) {
                $entityManager->remove($post);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_user_post', [], Response::HTTP_SEE_OTHER);
        }

        #[Route('/user/post/{idpost}/edit', name: 'app_post_front_edit', methods: ['GET', 'POST'])]
        public function editpost(Request $request, Post $post, EntityManagerInterface $entityManager): Response
        {
            $form = $this->createForm(PostFrontType::class, $post);
            $form->handleRequest($request);
       
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
       
                return $this->redirectToRoute('app_user_post', [], Response::HTTP_SEE_OTHER);
            }
       
            return $this->renderForm('user_post/editpost.html.twig', [
                'post' => $post,
                'form' => $form,
            ]);
        }
        #[Route('/search', name: 'blog_search', methods: ['GET'])]
        public function search(Request $request): Response
        {
            return $this->render('user_post/search.html.twig', ['query' => (string) $request->query->get('q', '')]);
        }


        #[Route('/recherche_ajax', name: 'recherche_ajax')]
        public function rechercheAjax(Request $request, SerializerInterface $serializer,PostRepository $productRepository): JsonResponse
        {
            $requestString = $request->query->get('searchValue');

           /* $resultats = $productRepository->findSBlogByTitre($requestString);*/

            if (empty($resultats)) {
                return new JsonResponse(['message' => 'No reclamations found.'], Response::HTTP_OK);
            }
            
            $data = [];

            foreach ($resultats as $res) {
                $data[] = [
                    'image' => $res->getImage(),
                    'description' => $res->getDescription(),
                    'nbCom' => $res->getNbCom(),
                    'date' => $res->getDate(),
                   
                    ];
                    
                   
            }

            $json = $serializer->serialize($data, 'json', ['groups' => 'reclamations', 'max_depth' => 1]);

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }


        

      
}
