<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{
    #[Route('/rating', name: 'app_rating')]
    public function index(): Response
    {
        return $this->render('rating/index.html.twig', [
            'controller_name' => 'RatingController',
        ]);
    }

    #[Route('/vote', name: 'app_vote')]
    public function submit(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données envoyées par la requête
        $artworkId = $request->request->get('artworkId');
        $rating = $request->request->get('rating');

        // Recherchez l'œuvre d'art associée à l'identifiant
        $artwork = $entityManager->getRepository(Product::class)->find($artworkId);

        if (!$artwork) {
            // Gérer le cas où l'œuvre d'art n'est pas trouvée
            return $this->json(['error' => 'L\'œuvre d\'art n\'a pas été trouvée.']);
        }

        // Récupérer l'utilisateur connecté (ou gérer la connexion utilisateur si nécessaire)
        $user = $this->getUser();


       /* if (!$user) {
            // Gérer le cas où l'utilisateur n'est pas connecté
            return $this->json(['error' => 'Vous devez être connecté pour voter.']);
        }*/

        // Vérifier si l'utilisateur a déjà voté pour cette œuvre
       // $existingVote = $entityManager->getRepository(Vote::class)->findOneBy(['users' => $user, 'oeuvres' => $artwork]);

        /*if ($existingVote) {
            // Mettre à jour la note existante
            $existingVote->setNoteVote($rating);
        } else {*/
            // Créer un nouveau vote
            $newVote = new Rating();
            $newVote->setIduser($user);
            $newVote->setIdproduct($artwork);
            $newVote->setNbstars($rating);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newVote);


        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        // Répondre avec un JSON pour indiquer que le vote a été enregistré avec succès
        return $this->json(['success' => true]);
    }

    #[Route('/Stat', name: 'app_debt_stat')]
    public function stat(DebtRepository $debtRepository): Response
    {
        // Get data for the chart
        $debtData = $debtRepository->getDebtDataForChart();

        // Format the data for Chart.js
        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Amount',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                    'data' => [],
                ],
            ],
        ];

        foreach ($debtData as $row) {
            $chartData['labels'][] = $row['type'];
            $chartData['datasets'][0]['data'][] = $row['totalAmount'];
        }

        // Render the template with the chart data
        return $this->render('debt/stat.html.twig', [
            'debtChartData' => json_encode($chartData),
        ]);
    }

}
