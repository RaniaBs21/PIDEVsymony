
<?php
/**
* @Route("/event/front/{idEv}/participate", name="app_event_participate")
*/
public function participateAction(Request $request, $idEv, MailerService $mailer)
{
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
$mailSubject = 'Confirmation d\'inscription';
$mailBody = 'Bonjour '.$admin->getNomU().' '.$admin->getPrenomU().',<br><br>Vous êtes inscrit à l\'événement "'.$event->getTitreEv().'".<br><br>Cordialement,<br>L\'équipe de gestion des événements.';
$recipientEmail = 'rahmaaslimii83@gmail.tn';


$this->addFlash('success', 'Vous êtes inscrit à l\'événement '.$event->getTitreEv());
$mailer->sendEmail($recipientEmail, $mailSubject, $mailBody);
}

return $this->redirectToRoute('app_event_front');
}
#[Route('/end', name: 'end')]
public function dx(ManagerRegistry $doctrine, Request $request): Response
{
    $em = $this->getDoctrine()->getManager();
    $id = 1;
    $adminRepository = $em->getRepository(Admin::class);
    $admin = $adminRepository->find($id);

    if (!$admin) {
        throw $this->createNotFoundException('User not found');
    }

    $points = new Points();
    $points->setAdmin($admin);

    $form = $this->createForm(PointsType::class, $points);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($points);
        $entityManager->flush();

        return $this->redirectToRoute('quiz_save_score');
    }

    return $this->render('home_front/end.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/quiz/saveScore', name: 'quiz_save_score')]
public function saveScore(ManagerRegistry $doctrine, Request $request ): Response
{
    $quizScore = new Points();
    $score = $request->query->get('score');
    $quizScore->setScore((int) $score);

    $adminId = 1; // Replace with the actual ID of the admin user
    $admin = $doctrine->getRepository(Admin::class)->find($adminId);
    $quizScore->setAdmin($admin);

    $form = $this->createForm(PointsType::class, $quizScore);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($quizScore);
        $entityManager->flush();

        return $this->redirectToRoute('end');
    }

    return $this->render('home_front/end.html.twig', [
        'quizScore' => $quizScore,
        'form' => $form->createView(),
    ]);
}
