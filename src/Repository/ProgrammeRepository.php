<?php

namespace App\Repository;
use App\Entity\Favoris;
use App\Entity\Programme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Programme>
 *
 * @method Programme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Programme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Programme[]    findAll()
 * @method Programme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programme::class);
    }
    public function addfavoris($idprog, $userid)
    {
        $entityManager = $this->getEntityManager();

        $favoris = new Favoris();
        $favoris->setIDUser($userid);
        $favoris->setIdprogramme($idprog);

        $entityManager->persist($favoris);
        $entityManager->flush();
    }

    public function deletefavoris($idprog, $userid)
    {
        $entityManager = $this->getEntityManager();
        $favoris = $entityManager->getRepository(Favoris::class)->findOneBy(['idprogramme' => $idprog, 'iduser' => $userid]);

        if ($favoris) {
            $entityManager->remove($favoris);
            $entityManager->flush();
        }
    }
    public function Recherche($idprog, $userid)
    {
        $entityManager = $this->getEntityManager();
        $favoris = $entityManager->getRepository(Favoris::class)->findOneBy(['idprogramme' => $idprog, 'iduser' => $userid]);
        if ($favoris)
            return true;
        else
            return false;
    }
//    /**
//     * @return Programme[] Returns an array of Programme objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Programme
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
