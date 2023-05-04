<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participation;
use App\Entity\Admin;
use App\Repository\EvenementRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface ;
use Symfony\Component\HttpFoundation\JsonResponse;
class EventFrontController extends AbstractController
{
    
    #[Route('/event/front', name: 'app_event_front')]
public function index(EvenementRepository $evenementRepository, PaginatorInterface $paginator, Request $request): Response
{
    $evenements = $evenementRepository->findAll();
    // Paginer la liste des evenements
    $EvPaginated = $paginator->paginate(
        $evenements,
        $request->query->getInt('page', 1),
        4 // Nombre d'éléments par page
    );

    return $this->render('event_front/index.html.twig', [
        'evenements' => $EvPaginated,
    ]);
    
}


    #[Route('/{idEv}', name: 'app_event_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('event_Front/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    

    /**
 * @Route("/event/front/{idEv}/participate", name="app_event_participate")
 */
    public function participateAction(Request $request, $idEv, MailerService $mailer)
    {
        /*var_dump($mailer->sendEmail("khaled.slimi1@gmail.com", "test ", "test body"));die;
        try {
            $mailer->sendEmail("khaled.slimi1@gmail.com", "test ", "test body");
        } catch (Exception $e) {
            var_dump($e->getMessage());die;
        }
        

        die('test');*/
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository(Evenement::class)->find($idEv);
        $idUt = 2; // ID de l'objet Admin à récupérer
        $adminRepository = $em->getRepository(Admin::class);
        $admin = $adminRepository->find($idUt);
        //$admin = $this->getUser(); // Utilise l'utilisateur connecté comme admin
        $participation = $em->getRepository(Participation::class)->findOneBy([
            'idU' => $admin,
            'idEv' => $event,
        ]);

        if (!$event) {
            throw $this->createNotFoundException('Event not found');
        } elseif($participation) {
            $this->addFlash('warning', 'Vous participez déjà à cet événement.');
        } else {
            $participation = new Participation();
            $participation->setIdU($admin);
            $participation->setIdEv($event);
            $participation->setDateParticipation(new \DateTime());

            $event->setNbrePlaces($event->getNbrePlaces() - 1);

            $em->persist($participation);
            $em->persist($event);
            $em->flush();

            /*$mailMessage = 'Bonjour'.' '.$admin->getNomU().' '.$admin->getPrenomU().' '.'Vous êtes inscrit à l\'événement '. ' '.$event->getTitreEv();
            
            $mailer->sendEmail($mailMessage);*/
            $subject = 'Confirmation d\'inscription';
            $content = 'Bonjour '.$admin->getNomU().' '.$admin->getPrenomU().',<br><br>Vous êtes inscrit à l\'événement "'.$event->getTitreEv().'".<br><br>Cordialement,<br>L\'équipe de gestion des événements.';
            $to = 'rahmaaslimii83@gmail.tn';
            
            $mailer->sendEmail($to, $subject, $content);
            //$mailer->sendEmail("khaled.slimi1@gmail.com", "test ", "test body");

            $this->addFlash('success', 'Vous êtes inscrit à l\'événement '.$event->getTitreEv().' avec succés! Veuillez consulter votre mail!');
        }
        
        return $this->redirectToRoute('app_event_front');
    }
    #[Route('/evenementshow/{id}', name: 'evenement_show')]
    public function showphoto(Evenement $evenement): Response
    {
        $photo = stream_get_contents($evenement->getImageEv());

        return new Response($photo, 200, ['Content-Type' => 'image/jpeg']);
    }
    
    #[Route('/event/front/filter', name: 'app_event_filter', methods: ['GET'])]
    public function filterByRegionAndCategory(Request $request)
    {
        $region = $request->query->get('region');
        $categorie = $request->query->get('categorie');

        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->createQueryBuilder('e')
            ->where('e.regionEv = :region')
            ->andWhere('e.categorieEv = :categorie')
            ->setParameter('region', $region)
            ->setParameter('categorie', $categorie)
            ->getQuery()
            ->getResult();

        return $this->render('evenements.html.twig', [
            'evenements' => $evenements,
        ]);
        return $this->render('event_Front/index.html.twig', [
            'evenement' => $evenement,
        ]);
    }

#[Route('/event/front/tri-evenements', name: 'app_event_tri', methods: ['POST'])]
public function triEvenements(Request $request, EvenementRepository $evenementRepository)
{
    // Récupération du critère de tri depuis la requête Ajax
    $tri = $request->request->get('tri');

    // Récupération de la liste des événements triée depuis la base de données

    if ($tri == 'titre') {
        // Si le critère de tri est "titre", on trie les événements par leur titre en ordre croissant
        $evenements = $evenementRepository->findBy([], ['titreEv' => 'ASC']);
    } else {
        // Sinon, on trie les événements par leur date en ordre croissant
        $evenements = $evenementRepository->findBy([], ['dateEv' => 'ASC']);
    }
    // Rendu d'une vue Twig contenant la liste d'événements triée
    return $this->render('event_front/index.html.twig', [
        'evenements' => $evenements,
        'tri' => $tri
    ]);
}
 
}