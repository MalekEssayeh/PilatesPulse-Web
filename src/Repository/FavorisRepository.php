<?php

namespace App\Repository;

use App\Entity\Favoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Programme;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Favoris>
 *
 * @method Favoris|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favoris|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favoris[]    findAll()
 * @method Favoris[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavorisRepository extends ServiceEntityRepository
{  
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Favoris::class);
        $this->entityManager = $entityManager;
    }

    public function findprog(): array
    {
        // Retrieve favorited program IDs
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('f.idprogramme')
            ->from(Favoris::class, 'f')
            ->where('f.iduser = :userId')
            ->setParameter('userId', 123); 

        $favoritedProgramIds = $queryBuilder->getQuery()->getResult();

        $favoritedPrograms = [];
        foreach ($favoritedProgramIds as $favoritedProgramId) {
            $program = $this->entityManager->getRepository(Programme::class)->find($favoritedProgramId);
            if ($program) {
                $favoritedPrograms[] = $program;
            }
        }

        return $favoritedPrograms;
    }


//    /**
//     * @return Favoris[] Returns an array of Favoris objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Favoris
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
