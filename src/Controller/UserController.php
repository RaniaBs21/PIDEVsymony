<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Form\PasswordProfileType;
use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use App\Entity\PdfGeneratorService;
class UserController extends AbstractController
{

   

    /**
     * @Route("/profile/delete", name="delete_profile", methods={"POST"})
     */
    public function delete_profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/profile/editPassword", name="edit_profile_password", methods={"GET", "POST"})
     */
    public function edituserpassword(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/profile_edit_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/edit", name="edit_profile", methods={"GET" , "POST" })
     */
    public function edit_profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/profile_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/profile", name="profile", methods={"GET"})
     */
    public function profile(UserRepository $userRepository): Response
    {

        return $this->render('user/profile.html.twig', [
            'user' => $userRepository->findOneBy(['id' => $this->getUser()->getId()]),
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/ActivateAccountWithCode", name="ActivateAccountWithCode", methods={"GET","POST"})
     */
    public function ActivateAccountWithCode(UserRepository $userRepository, Request $request,PaginatorInterface $paginator): Response
    {
        $error = null;
        if ( $request->isMethod('POST')) {
            $code = $request->request->get('verificationcode');
            $codeUser = $this->getUser()->getVerificationCode();
            if ( $code == $codeUser){
                $user = new User();
                $user = $this->getUser();
                $user->setVerificationCode(null);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute("app_login");
            }
            else{
                $error = "Please Verify your Code";
                return $this->render('security/ActivateAccountWithCode.html.twig',[
                    'error' => $error,
                ]);
            }
        }
        return $this->render('security/ActivateAccountWithCode.html.twig',[
            'error' => $error,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/user/", name="user_index", methods={"GET", "POST"})
     */
    public function index(UserRepository $userRepository, Request $request,PaginatorInterface $paginator): Response
    {
        $back = null;
        if ( $request->isMethod('POST')) {

            if ( $request->request->get('optionsRadios')){
                $SortKey = $request->request->get('optionsRadios');
                switch ($SortKey){
                    case 'email':
                        $users = $userRepository->SortByEmail();
                        break;

                    case 'firstname':
                        $users = $userRepository->SortByFirstName();
                        break;

                    case 'usertag':
                        $users = $userRepository->SortByUserTag();
                        break;

                    case 'phonenumber':
                        $users = $userRepository->SortByPhoneNumber();
                        break;
                }
            }
            else
            {
                $type = $request->request->get('optionsearch');
                $value = $request->request->get('Search');
                switch ($type){
                    case 'email':
                        $users = $userRepository->findByEmail($value);
                        break;

                    case 'firstname':
                        $users = $userRepository->findByFirstName($value);
                        break;

                    case 'lastname':
                        $users = $userRepository->findByLastName($value);
                        break;

                    case 'usertag':
                        $users = $userRepository->findByUserTag($value);
                        break;

                    case 'phonenumber':
                        $users = $userRepository->findByPhoneNumber($value);
                        break;
                }
            }


            if ( $users){
                $back = "success";
            }else{
                $back = "failure";
            }

            $usersPaginator = $paginator->paginate(
                $users, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                5 // Nombre de résultats par page
            );

            return $this->render('user/index.html.twig', [
                'users' => $usersPaginator,
                'back' => $back,
            ]);
        }

        $users = $userRepository->findAll();
        $usersPaginator = $paginator->paginate(
            $users, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );

        return $this->render('user/index.html.twig', [
            'users' => $usersPaginator,
            'back' => $back,
        ]);
    }

    /**
     * @Route("/user/new", name="user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/editusernp", name="user_edit", methods={"GET", "POST"})
     */
    public function editusernp(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/disable_user/{id}", name="disable_user", methods={"GET", "POST"})
     */
    public function disable_user(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setDisableToken("1");
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/enable_user/{id}", name="enable_user", methods={"GET", "POST"})
     */
    public function enable_user(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setDisableToken(null);
        $entityManager->persist($user);
        $entityManager->flush();
        //$link = $request->headers->get("referer");
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);

    }


    /**
     * @Route("/DisabledAccount", name="DisabledAccount")
     */
    public function DisabledAccount(): Response
    {
        return $this->render('user/DisabledAccount.html.twig');
    }


    



}
