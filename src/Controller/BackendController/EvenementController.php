<?php

namespace App\Controller\BackendController;


use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    #[Route('/new', name: 'app_evenemhods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageEv')->getData();
            if ($imageFile instanceof UploadedFile) {
                $blob = file_get_contents($imageFile->getPathname());
                $evenement->setImageEv($blob);
            }

            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{idEv}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{idEv}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageEv')->getData();
            if ($imageFile instanceof UploadedFile) {
                $blob = file_get_contents($imageFile->getPathname());
                $evenement->setImageEv($blob);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{idEv}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getIdEv(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }  
    
        /**
         * @Route("/recherche_ajax", name="recherche_ajax")
         */
        public function rechercheAjax(Request $request, SerializerInterface $serializer,EvenementRepository $evenementRepository): JsonResponse
        {
            $requestString = $request->query->get('searchValue');

            $resultats = $evenementRepository->find($requestString);

            if (empty($resultats)) {
                return new JsonResponse(['message' => 'No evenements found.'], Response::HTTP_OK);
            }
            
            $data = [];

            foreach ($resultats as $res) {
                $data[] = [
                    'id' => $res->getIdEv(),
                    'titre' => $res->getTitreEv(),
                    'description' => $res->getDescriptionEv(),
                    'image' => $res->getImageEv(),
                    'adresse' => $res->getAdresseEV(),
                    'date' => $res->getDateEv(),
                    

                    ];
            }

            $json = $serializer->serialize($data, 'json', ['groups' => 'evnements', 'max_depth' => 1]);

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
}
