<?php

namespace App\Repository;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use App\Entity\Exercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercice>
 *
 * @method Exercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercice[]    findAll()
 * @method Exercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercice::class);
    }

    //    /**
    //     * @return Exercice[] Returns an array of Exercice objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Exercice
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function QRcode($nom, $difficulte, $muscle, $evaluation)
    {
        $text = sprintf(
            "Exercice Name: %s\nMuscle worked: %s\nDifficulty: %s\nEvaluation %s",
            $nom,
            $difficulte,
            $muscle,
            $evaluation
        );
        $qr_code = QrCode::create($text)
            ->setSize(130)
            ->setMargin(0)
            ->setForegroundColor(new Color(240,166,202))
            ->setBackgroundColor(new Color(236, 233, 230));

        $writer = new PngWriter;

        $result = $writer->write($qr_code);

        header("Content-Type: image/png");
        $imageData = base64_encode($result->getString());
        return 'data:image/png;base64,' . $imageData;
    }
}
