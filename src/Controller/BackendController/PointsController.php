<?php

namespace App\Controller\BackendController;

use App\Entity\Points;
use App\Form\Points1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/points')]
class PointsController extends AbstractController
{
    #[Route('/', name: 'app_points_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $points = $entityManager
            ->getRepository(Points::class)
            ->findAll();

        return $this->render('points/index.html.twig', [
            'points' => $points,
        ]);
    }

    #[Route('/new', name: 'app_points_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $point = new Points();
        $form = $this->createForm(Points1Type::class, $point);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($point);
            $entityManager->flush();

            return $this->redirectToRoute('app_points_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('points/new.html.twig', [
            'point' => $point,
            'form' => $form,
        ]);
    }

    #[Route('/{idPoints}', name: 'app_points_show', methods: ['GET'])]
    public function show(Points $point): Response
    {
        return $this->render('points/show.html.twig', [
            'point' => $point,
        ]);
    }

    #[Route('/{idPoints}/edit', name: 'app_points_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Points $point, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Points1Type::class, $point);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_points_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('points/edit.html.twig', [
            'point' => $point,
            'form' => $form,
        ]);
    }

    #[Route('/{idPoints}', name: 'app_points_delete', methods: ['POST'])]
    public function delete(Request $request, Points $point, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$point->getIdPoints(), $request->request->get('_token'))) {
            $entityManager->remove($point);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_points_index', [], Response::HTTP_SEE_OTHER);
    }
}
