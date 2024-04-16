<?php

namespace App\Repository;

use App\Entity\Shoppingcart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Shoppingcart>
 *
 * @method Shoppingcart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shoppingcart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shoppingcart[]    findAll()
 * @method Shoppingcart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingcartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shoppingcart::class);
    }

//    /**
//     * @return Shoppingcart[] Returns an array of Shoppingcart objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Shoppingcart
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
