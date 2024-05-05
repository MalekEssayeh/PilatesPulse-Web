<?php

namespace App\Controller;

use App\Entity\Wishlist;
use App\Form\WishlistType;
use App\Repository\ProductRepository;
use App\Repository\WishlistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Product;



#[Route('/wishlist')]
class WishlistController extends AbstractController
{
    #[Route('/', name: 'app_wishlist_index', methods: ['GET'])]
    public function index(WishlistRepository $wishlistRepository): Response
    {
        return $this->render('wishlist/index.html.twig', [
            'wishlists' => $wishlistRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_wishlist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wishlist = new Wishlist();
        $form = $this->createForm(WishlistType::class, $wishlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($wishlist);
            $entityManager->flush();

            return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wishlist/new.html.twig', [
            'wishlist' => $wishlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wishlist_show', methods: ['GET'])]
    public function show(Wishlist $wishlist): Response
    {
        return $this->render('wishlist/show.html.twig', [
            'wishlist' => $wishlist,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_wishlist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Wishlist $wishlist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WishlistType::class, $wishlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wishlist/edit.html.twig', [
            'wishlist' => $wishlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wishlist_delete', methods: ['POST'])]
    public function delete(Request $request, Wishlist $wishlist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wishlist->getId(), $request->request->get('_token'))) {
            $entityManager->remove($wishlist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/addtowishlist/{idproduct<\d+>}', name: 'add_to_wishlist')]
    public function add(ProductRepository $productRepository, int $idproduct, EntityManagerInterface $entityManager): Response
    {
        $product = $productRepository->find($idproduct);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $wishlistItem = new Wishlist();
        $wishlistItem->setIdproduct($product->getIdproduct()); // Assuming setIdproduct() expects product ID
        $wishlistItem->setNameproduct($product->getNameproduct());
        $wishlistItem->setImage($product->getImage());
        $wishlistItem->setProductdescription($product->getProductdescription());
        $wishlistItem->setPriceproduct($product->getPriceproduct());

        $entityManager->persist($wishlistItem);
        $entityManager->flush();

        $this->addFlash('success', 'Product added to wish list');

        return $this->redirectToRoute('app_wishlist_index');
    }
}
