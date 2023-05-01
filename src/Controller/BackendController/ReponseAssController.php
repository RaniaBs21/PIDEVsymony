<?php

namespace App\Controller\BackendController;

use App\Entity\ReponseAss;
use App\Form\ReponseAssType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use App\Service\PdfService;

#[Route('/reponse/ass')]
class ReponseAssController extends AbstractController
{


    private $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    #[Route('/', name: 'app_reponse_ass_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reponseAsses = $entityManager
            ->getRepository(ReponseAss::class)
            ->findAll();

        return $this->render('reponse_ass/index.html.twig', [
            'reponse_asses' => $reponseAsses,
        ]);
    }

    #[Route('/new', name: 'app_reponse_ass_new', methods: ['GET', 'POST'])]
    public function ReponseAss(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $reponseAss = new ReponseAss();
        $form = $this->createForm(ReponseAssType::class, $reponseAss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponseAss);
            $entityManager->flush();

            // Generate PDF
            $html = $this->renderView('reponse_ass/show2.html.twig', [
                'reponse_ass' => $reponseAss,
            ]);

            // Download PDF
            $this->pdfService->showPdfFile($html);

            // Or generate binary PDF
            // $binaryPdf = $this->pdfService->generateBinaryPDF($html);

            return $this->redirectToRoute('app_reponse_ass_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_ass/new.html.twig', [
            'reponse_ass' => $reponseAss,
            'form' => $form,
        ]);
    }

    #[Route('/{idRepAss}', name: 'app_reponse_ass_show', methods: ['GET'])]
    public function show(ReponseAss $reponseAss): Response
    {
        return $this->render('reponse_ass/show.html.twig', [
            'reponse_ass' => $reponseAss,
        ]);
    }

    #[Route('/{idRepAss}/edit', name: 'app_reponse_ass_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReponseAss $reponseAss, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseAssType::class, $reponseAss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_ass_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_ass/edit.html.twig', [
            'reponse_ass' => $reponseAss,
            'form' => $form,
        ]);
    }

    #[Route('/{idRepAss}', name: 'app_reponse_ass_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseAss $reponseAss, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseAss->getIdRepAss(), $request->request->get('_token'))) {
            $entityManager->remove($reponseAss);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_ass_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/searchR', name: 'app_reponse_ass_search', methods: ['GET', 'POST'])]
public function search(Request $request, EntityManagerInterface $entityManager): Response
{
    $typeRepAss = $request->query->get('typeRepAss');
    $sort = $request->query->get('sort');
    $direction = $request->query->get('direction');

    $reponseAsses = $entityManager
        ->getRepository(ReponseAss::class)
        ->findBy(['typeRepAss' => $typeRepAss], [$sort => $direction]);

    return $this->render('reponse_ass/index.html.twig', [
        'reponse_asses' => $reponseAsses,
    ]);
}

}