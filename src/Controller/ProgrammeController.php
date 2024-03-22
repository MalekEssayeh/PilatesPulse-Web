<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Entity\Favoris;
use App\Entity\Programme;
use App\Form\ProgrammeType;
use App\Repository\FavorisRepository;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


#[Route('/programme')]
class ProgrammeController extends AbstractController
{
    #[Route('/', name: 'app_programme_index', methods: ['GET'])]
    public function index(ProgrammeRepository $programmeRepository): Response
    {
        return $this->render('programme/index.html.twig', [
            'programmes' => $programmeRepository->findAll(),
            'programmeRepository' => $programmeRepository
        ]);
    }
    #[Route('/favoris', name: 'app_favoris_index', methods: ['GET'])]
    public function indexfavoris(FavorisRepository $favorisRepository): Response
    {
        return $this->render('programme/Favoris.html.twig', [
            'programmes' => $favorisRepository->findprog(),
        ]);
    }

    #[Route('/new', name: 'app_programme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $programme = new Programme();
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $connection = $entityManager->getConnection();

            $sql = "SELECT idprogramme FROM programme ORDER BY idprogramme DESC LIMIT 1";

            $statement = $connection->executeQuery($sql);

            $result = $statement->fetchAssociative();

            $idprogramme = $result['idprogramme'];
            $idprogramme++;
            $programme->setEvaluationprogramme(1);
            $programme->setIdcoachp(123);
            $entityManager->persist($programme);
            $entityManager->flush();
            foreach ($programme->getListexercice() as $value) {
                $sql = '
            INSERT INTO Listexercice (IDex,idProg)
            VALUES (:value1, :value2)';

                $params = [
                    'value1' => $value->getId(),
                    'value2' => $idprogramme,
                ];

                $statement = $connection->prepare($sql);
                $statement->executeStatement($params);
            }
            return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('programme/new.html.twig', [
            'programme' => $programme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programme_show', methods: ['GET'])]
    public function show(Programme $programme): Response
    {
        return $this->render('programme/show.html.twig', [
            'programme' => $programme,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_programme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Programme $programme, EntityManagerInterface $entityManager): Response
    {
        $connection = $entityManager->getConnection();

        $sql = "SELECT * FROM listExercice WHERE idProg = :id";

        $statement = $connection->executeQuery($sql, ['id' => $programme->getidprogramme()]);

        $results = $statement->fetchAllAssociative();


        foreach ($results as $result) {
            $sql = "SELECT * FROM exercice WHERE idExercice = :id";

            $statement = $connection->executeQuery($sql, ['id' => $result['IDex']]);

            $res = $statement->fetchAssociative();

            $exercice = $entityManager->getRepository(Exercice::class)->find($res['idExercice']);
            if ($exercice) {
                $programme->Listexercice[] = $exercice;
            }
        }


        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($results as $result) {
                $sql = 'DELETE FROM Listexercice  WHERE IDex = :id';
                $params = [
                    'id' => $result['IDex'],
                ];
                $statement = $connection->prepare($sql);
                $statement->executeStatement($params);
            }
            foreach ($programme->getListexercice() as $value) {
                $sql = 'INSERT INTO Listexercice (IDex,idProg) VALUES (:value1, :value2)';
                $params = [
                    'value1' => $value->getId(),
                    'value2' => $programme->getidprogramme(),
                ];
                $statement = $connection->prepare($sql);
                $statement->executeStatement($params);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('programme/edit.html.twig', [
            'programme' => $programme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/n', name: 'app_programme_delete')]
    public function delete(Programme $programme, EntityManagerInterface $entityManager): Response
    {
        $connection = $entityManager->getConnection();

        $entityManager->remove($programme);
        $entityManager->flush();
        $sql = "DELETE FROM `ListExercice` WHERE IDprog = :id";
        $connection->executeQuery($sql, ['id' => $programme->getidprogramme()]);


        return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/toggle-favorite', name: 'toggle_favorite', methods: ['POST'])]
    public function toggleFavorite(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $programmeId = $request->request->get('programmeId');
        $isStarred = $request->request->get('isStarred');

        $favorisRepository = $entityManager->getRepository(Favoris::class);
        $favoris = $favorisRepository->findOneBy(['idprogramme' => $programmeId, 'iduser' => 123]); // Assuming 123 is the user ID

        if ($isStarred === 'false') {
            if (!$favoris) {
                $favoris = new Favoris();
                $favoris->setIdprogramme($programmeId);
                $favoris->setIdUser(123); // Assuming 123 is the user ID
                $entityManager->persist($favoris);
                $entityManager->flush();
            }
            return new JsonResponse(['success' => true]);
        } else {
            if ($favoris) {
                $entityManager->remove($favoris);
                $entityManager->flush();
            }
            return new JsonResponse(['success' => true]);
        }
    }
    #[Route('/n/recom', name: 'recom')]
    public function recom(): Response
    {
        $command = ['python', 'C:\xampp\htdocs\PilatePulse\src\RecomIA.py', 'Homme', '16', '150', '71'];

        $process = new Process($command);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output = $process->getOutput();

        return $this->render('programme/recommandation.html.twig', [
            'programmes' => $output,
        ]);
    }
}
