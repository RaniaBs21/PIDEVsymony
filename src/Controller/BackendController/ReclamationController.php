<?php

namespace App\Controller\BackendController;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gregwar\CaptchaBundle\Type\CaptchaType;


#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    

    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }
        /**
 * @Route("/index2", name="app_reclamation_front_index2", methods={"GET","POST"})
 */
    public function index2(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();

        return $this->render('reclamation/index2.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

        #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
        public function new(Request $request, EntityManagerInterface $entityManager): Response
        {
            $reclamation = new Reclamation();
            $form = $this->createForm(ReclamationType::class, $reclamation)
                ->add('captcha', CaptchaType::class, [
                    'label' => 'Captcha',
                    'invalid_message' => 'Invalid captcha code'
                ]);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($reclamation);
                $entityManager->flush();
        
                return $this->redirectToRoute('app_reclamation_front_index2', [], Response::HTTP_SEE_OTHER);
            }
        
            return $this->renderForm('reclamation/new.html.twig', [
                'reclamation' => $reclamation,
                'form' => $form,
            ]);
        }
    /**
 * @Route("/new2", name="app_reclamation_front_new2", methods={"GET","POST"})
 */
public function new2(Request $request, EntityManagerInterface $entityManager): Response
{
    $reclamation = new Reclamation();
    $form = $this->createForm(ReclamationType::class, $reclamation)
        ->add('captcha', CaptchaType::class, [
            'label' => 'Captcha',
            'invalid_message' => 'Invalid captcha code'
        ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($reclamation);
        $entityManager->flush();

        return $this->redirectToRoute('app_reclamation_front_index2');
    }

    return $this->render('reclamation/newfront.html.twig', [
        'reclamation' => $reclamation,
        'form' => $form->createView(),
    ]);
}
    /**
 * @Route("/{idRec}/show2", name="app_reclamation_front_show2", methods={"GET"})
 */
public function show2(Reclamation $reclamation): Response
{
    return $this->render('reclamation/show2.html.twig', [
        'reclamation' => $reclamation,
    ]);
}
    #[Route('/{idRec}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idRec}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    /**
 * @Route("/{idRec}/edit2", name="app_reclamation_front_edit2", methods={"GET","POST"})
 */
    public function edit2(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_front_index2', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit2.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idRec}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

        /**
 * @Route("/{idRec}/delete2", name="app_reclamation_front_delete2", methods={"POST"})
 */
    public function delete2(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_front_index2', [], Response::HTTP_SEE_OTHER);
    }

#[Route('/searchRec', name: 'app_reclamation_search', methods: ['GET', 'POST'])]
public function search(Request $request, EntityManagerInterface $entityManager): Response
{
    $typeRec = $request->query->get('typeRec');
    $sort = $request->query->get('sort');
    $direction = $request->query->get('direction');

    if (!$typeRec && in_array($sort, ['idRec', 'typeRec', 'descriptionRec'])) {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findBy([], [$sort => $direction]);
    } else {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findBy(['typeRec' => $typeRec], [$sort => $direction]);
    }

    return $this->render('reclamation/index.html.twig', [
        'reclamations' => $reclamations,
    ]);
}
/**
 * @Route("/search2", name="app_reclamation_front_search2", methods={"GET","POST"})
 */
public function search2(Request $request, EntityManagerInterface $entityManager): Response
{
    $typeRec = $request->query->get('typeRec');
    $sort = $request->query->get('sort');
    $direction = $request->query->get('direction');

    if (!$typeRec && in_array($sort, ['idRec', 'typeRec', 'descriptionRec'])) {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findBy([], [$sort => $direction]);
    } else {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findBy(['typeRec' => $typeRec], [$sort => $direction]);
    }

    return $this->render('reclamation/index2.html.twig', [
        'reclamations' => $reclamations,
    ]);
}


}