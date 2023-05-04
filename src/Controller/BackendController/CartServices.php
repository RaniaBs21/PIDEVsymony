<?php

namespace App\Controller\BackendController;
use App\Entity\Admin;
use App\Entity\Cart;
use App\Entity\Produit;
use App\Entity\CartItems;
use App\Form\CartType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/cart/services')]
class CartServices extends AbstractController
{
   #[Route('/', name: 'app_cart_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $carts = $entityManager
            ->getRepository(Cart::class)
            ->findAll();

        return $this->render('cart/index.html.twig', [
            'carts' => $carts,
        ]);
    }

    #[Route('/new', name: 'app_cart_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cart = new Cart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cart/new.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }

    #[Route('/{idCart}', name: 'app_cart_show', methods: ['GET'])]
    public function show(Cart $cart): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/{idCart}/edit', name: 'app_cart_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cart/edit.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }

    #[Route('/{idCart}', name: 'app_cart_delete', methods: ['POST'])]
    public function delete(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getIdCart(), $request->request->get('_token'))) {
            $entityManager->remove($cart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/add-to-cart/{idProduit}', name: 'app_cart_add_to_cart', methods: ['POST'])]
    public function addToCart(EntityManagerInterface $entityManager, Produit $produit): Response
    {
        // Find or create the static user
        $user = $entityManager->getRepository(Admin::class)->findOneBy(['age' => 1]);
        if (!$user) {
            $user = new Admin();
            $user->setAge(1);
            $entityManager->persist($user);
            $entityManager->flush();
        }
        
        // Create a new cart and assign it to the user
        $cart = new Cart();
        $cart->setIdProd($produit->getIdProd());
        $cart->setId($user->getId());
        $entityManager->persist($cart);
        $entityManager->flush();
        
        // Redirect back to the product page
        return $this->redirectToRoute('produit_show', ['id' => $produit->getIdProd()]);
    }
    
    

}
