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




    public function findCartItemByUserAndProduct(int $userId, int $productId): ?Shoppingcart
    {
        return $this->em->getRepository(Shoppingcart::class)
            ->findOneBy([1 => $userId, 'idproduct' => $productId]);
    }
 public function calculateTotalPrice(): float
{
      $totalPrice = 0;
     $shoppingcarts = $this->em->getRepository(Shoppingcart::class)->findAll();

        foreach ($shoppingcarts as $shoppingcart) {
            $totalPrice += $shoppingcart->getPriceproduct() * $shoppingcart->getQuantity();
       }

return $totalPrice;
    }
    
    

}