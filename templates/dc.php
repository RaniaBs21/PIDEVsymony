#[Route('/ajoutcours', name: 'ajoutcours')]
public function ajout(ManagerRegistry $doctrine, Request $request): Response
{
$cours = new Cours();
$form = $this->createForm(CoursType::class, $cours);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
$em = $doctrine->getManager();

// Ajoutez ce code pour gérer l'upload de l'image
$imageFile = $form->get('fichierC')->getData();
if ($imageFile) {
$imageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
$newFilename = $imageName.'-'.uniqid().'.'.$imageFile->guessExtension();
$imageFile->move(
$this->getParameter('images_directory'),
$newFilename
);
$cours->setImageName($newFilename);
}

$em->persist($cours);
$em->flush();

// Ajouter un message de succès dans la session
$this->addFlash('success', 'Le cours a été ajouté avec succès.');

return $this->redirectToRoute('ajoutcours');
} else if ($form->isSubmitted()) {
$this->addFlash('error', 'Le titre est obligatoire');
}

return $this->render('cours/ajoutcours.html.twig', [
'formCours' => $form->createView(),
'imageName' => $cours->getImageName(),
]);
}