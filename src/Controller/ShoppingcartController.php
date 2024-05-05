<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Shoppingcart;
use App\Form\Shoppingcart1Type;
use App\Repository\ProductRepository;
use App\Repository\ShoppingcartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/shoppingcart')]
class ShoppingcartController extends AbstractController
{
    #[Route('/', name: 'app_shoppingcart_index', methods: ['GET'])]
    public function index(ShoppingcartRepository $shoppingcartRepository): Response
    {
        //dd($shoppingcartService->getTotal());
        return $this->render('shoppingcart/index.html.twig', [
            'shoppingcarts' => $shoppingcartRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_shoppingcart_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shoppingcart = new Shoppingcart();
        $form = $this->createForm(Shoppingcart1Type::class, $shoppingcart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($shoppingcart);
            $entityManager->flush();

            return $this->redirectToRoute('app_shoppingcart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shoppingcart/new.html.twig', [
            'shoppingcart' => $shoppingcart,
            'form' => $form,
        ]);
    }

    #[Route('/{idshoppingcart}', name: 'app_shoppingcart_show', methods: ['GET'])]
    public function show(Shoppingcart $shoppingcart): Response
    {
        return $this->render('shoppingcart/show.html.twig', [
            'shoppingcart' => $shoppingcart,
        ]);
    }

    #[Route('/{idshoppingcart}/edit', name: 'app_shoppingcart_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Shoppingcart $shoppingcart, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Shoppingcart1Type::class, $shoppingcart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_shoppingcart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shoppingcart/edit.html.twig', [
            'shoppingcart' => $shoppingcart,
            'form' => $form,
        ]);
    }

    #[Route('/{idshoppingcart}', name: 'app_shoppingcart_delete', methods: ['POST'])]
    public function delete(Request $request, Shoppingcart $shoppingcart, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shoppingcart->getIdshoppingcart(), $request->request->get('_token'))) {
            $entityManager->remove($shoppingcart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_shoppingcart_index', [], Response::HTTP_SEE_OTHER);
    }

    public function removeProduct(Product $product, ShoppingcartService $shoppingcartService): void
    {
        $shoppingcartService->removeProduct($product);
    }

    #[Route('/addtocart/{idproduct<\d+>}', name: 'add_to_cart')]
public function add(Request $request, ProductRepository $productRepository, int $idproduct, ShoppingcartService $shoppingcartService, EntityManagerInterface $entityManager): Response
{
    $user = 1;
    $quantity = $request->request->get('quantity',1);

    $product = $productRepository->find($idproduct);

    if (!$product) {
        throw $this->createNotFoundException('Product not found');
    }

    if ($quantity > $product->getStock()) {
        $this->addFlash('error', 'We do not have enough stock for this quantity.');
        return $this->redirectToRoute('app_product_show', ['idproduct' => $product->getIdproduct()]);
    }

    $shoppingcart = new Shoppingcart();
    $shoppingcart->setIduser($user);
    $shoppingcart->setIdProduct($product->getIdproduct());
    $shoppingcart->setNameproduct($product->getNameproduct());
    $shoppingcart->setImage($product->getImage());
    $shoppingcart->setProductdescription($product->getProductdescription());
    $shoppingcart->setQuantity($quantity);
    $shoppingcart->setPriceproduct($product->getPriceproduct());

    $entityManager->persist($shoppingcart);
    $entityManager->flush();

    $this->addFlash('success', 'Product added to cart successfully!');

    return $this->redirectToRoute('app_shoppingcart_index');
}

    #[Route('/removeall', name: 'app_shoppingcart_remove_all')]
    public function removeAll(ShoppingcartService $shoppingcartService): Response
    {
        $shoppingcartService->removeAll();
        return $this->redirectToRoute('app_product_index');
    }


    #[Route('/', name: 'app_shoppingcart_index', methods: ['GET'])]
    public function index1(ShoppingcartRepository $shoppingcartRepository, ShoppingcartService $shoppingcartService): Response
    {
        $shoppingcarts = $shoppingcartRepository->findAll();
        $totalPrice = $shoppingcartService->calculateTotalPrice();

        return $this->render('shoppingcart/index.html.twig', [
            'shoppingcarts' => $shoppingcarts,
           'totalPrice' => $totalPrice,
        ]);
    }
}

