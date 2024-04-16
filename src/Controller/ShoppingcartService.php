<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Shoppingcart;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\DBAL\DriverManager;


class ShoppingcartService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;

    }
    private function getSession() : SessionInterface{
        return $this ->requestStack->getSession();
    }



    public function removeAll(){
        return $this->getSession()->remove('shoppingcart');
    }


    public function getTotal(): array {
        $cart = $this->getSession()->get('shoppingcart');
        $cartData = [];

        // Check if the cart is empty
        if (empty($cart)) {
            return $cartData; // Return an empty array if the cart is empty
        }

        foreach ($cart as $id => $quantity) {
            $product = $this->em->getRepository(Product::class)->findOneBy(['idproduct' => $id]);
            if (!$product) {
                // Handle the case where the product with the given id does not exist
                // You may choose to skip this product and continue with the loop or handle it in a different way
                continue;
            }
            $cartData[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
        return $cartData;
    }

    public function findCartItemByUserAndProduct(int $userId, int $productId): ?Shoppingcart
    {
        return $this->em->getRepository(Shoppingcart::class)
            ->findOneBy([1 => $userId, 'idProduct' => $productId]);
    }


}