<?php

namespace App\Controller\BackendController;

use App\Entity\Commande;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CommandeModifType;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;
#[Route('/commande/services')]
class CommandeServicesController extends AbstractController
{
    #[Route('/', name: 'app_commande_services_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande_services/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/new', name: 'app_commande_services_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,MailerInterface $mailer, LoggerInterface $logger): Response
    { $commande = new Commande();
     $form = $this->createForm(CommandeType::class, $commande);
     $form->handleRequest($request);
 
     $transport = new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl');
     $transport->setUsername('chedy.bouhlel@esprit.tn');
     $transport->setPassword('hcyknsidkhwywgfv');
     $mailer = new Swift_Mailer($transport);
 
     if ($form->isSubmitted() && $form->isValid()) {
         $dateCommande = $commande->getDateCmd();
         $dateLivraison = $commande->getDateLiv();
 
         $entityManager->persist($commande);
         $entityManager->flush();
 
         $message = new Swift_Message();
         $message->setSubject('Information de votre commande');
         $message->setFrom(['chedy.bouhlel@esprit.tn' => 'ARTplus']);
         $message->setTo(['chedybouhlel00@gmail.com']);
 
         $messageBody = "Votre commande est confirmée.\n\n";
         $messageBody .= "Date de commande: " . $dateCommande->format('Y-m-d H:i:s') . "\n";
         $messageBody .= "Date de livraison: " . $dateLivraison->format('Y-m-d H:i:s') . "\n";
 
         $message->setBody($messageBody);
 
         $mailer->send($message);
 
         return $this->redirectToRoute('app_commande_services_index', [], Response::HTTP_SEE_OTHER);
     }
 
     return $this->renderForm('commande_services/new.html.twig', [
         'commande' => $commande,
         'form' => $form,
     ]);
     
    }

    #[Route('/{idCmd}', name: 'app_commande_services_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande_services/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{idCmd}/edit', name: 'app_commande_services_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeModifType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_services/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{idCmd}', name: 'app_commande_services_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getIdCmd(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_services_index', [], Response::HTTP_SEE_OTHER);
    }

}
