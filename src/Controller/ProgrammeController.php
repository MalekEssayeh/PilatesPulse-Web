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

            $programme->setEvaluationprogramme(1);
            $programme->setIdcoachp(123);
            $entityManager->persist($programme);
            $entityManager->flush();
            $statement = $connection->executeQuery($sql);

            $result = $statement->fetchAssociative();

            $idprogramme = $result['idprogramme'];

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
            $entityManager->persist($programme);
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
    #[Route('/n/recom', name: 'recom', methods: ['POST'])]
    public function recom(Request $request, EntityManagerInterface $entityManager, ProgrammeRepository $programmeRepository): Response
    {
        $sexe = $request->request->get('sexe');
        $age = (string)$request->request->get('age');
        $weight = (string)$request->request->get('weight');
        $height = (string)$request->request->get('height');
        $command = ['python', 'C:\xampp\htdocs\PilatePulse\src\RecomIA.py', $sexe, $age, $height, $weight];
        $process = new Process($command);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output = $process->getOutput();
        $programmes = [];


        $programmeRepository = $entityManager->getRepository(Programme::class);
        $exerciceRepository = $entityManager->getRepository(Exercice::class);
        $connection = $entityManager->getConnection();

        $programmesData = $programmeRepository->findAll();

        foreach ($programmesData as $programmeData) {

            $sql = "SELECT * FROM listExercice WHERE idProg = :id";

            $statement = $connection->executeQuery($sql, ['id' => $programmeData->getidprogramme()]);

            $results = $statement->fetchAllAssociative();


            foreach ($results as $result) {
                $sql = "SELECT * FROM exercice WHERE idExercice = :id";

                $statement = $connection->executeQuery($sql, ['id' => $result['IDex']]);

                $res = $statement->fetchAssociative();

                $exercice = $entityManager->getRepository(Exercice::class)->find($res['idExercice']);
                if ($exercice) {
                    $programmeData->Listexercice[] = $exercice;
                }
            }


            $programmes[] = $programmeData;
        }

        return $this->render('programme/recommandation.html.twig', [
            'programmes' =>        $programmeRepository->recommanded($programmes, $output),
            'programmeRepository' => $programmeRepository

        ]);
    }
    #[Route('/n/recform', name: 'recform')]
    public function recform(): Response
    {
        return $this->render('programme/recform.html.twig', []);
    }
    /****************************************************** BAAAAAAAAAAAACK************************************** */
    #[Route('/back/index', name: 'app_programme_indexb', methods: ['GET'])]
    public function indexb(ProgrammeRepository $programmeRepository, EntityManagerInterface $entityManager): Response
    {
        $connection = $entityManager->getConnection();
        $programmes = [];
        foreach ($programmeRepository->findAll() as $programme) {
            $sql = "SELECT * FROM listExercice WHERE idProg = :id";
            $statement = $connection->executeQuery($sql, ['id' => $programme->getidprogramme()]);
            $results = $statement->fetchAllAssociative();
            $listExercices = [];
            foreach ($results as $result) {
                $sql = "SELECT * FROM exercice WHERE idExercice = :id";
                $statement = $connection->executeQuery($sql, ['id' => $result['IDex']]);
                $res = $statement->fetchAssociative();
                $exercice = $entityManager->getRepository(Exercice::class)->find($res['idExercice']);
                if ($exercice) {
                    $listExercices[] = $exercice;
                }
            }
            $programme->Listexercice = $listExercices;
            $programmes[] = $programme;
        }

        return $this->render('back/programme/index.html.twig', [
            'programmes' => $programmes,
            'programmeRepository' => $programmeRepository
        ]);
    }


    #[Route('/back/new', name: 'app_programme_newb', methods: ['GET', 'POST'])]
    public function newb(Request $request, EntityManagerInterface $entityManager): Response
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
            return $this->redirectToRoute('app_programme_indexb', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/programme/new.html.twig', [
            'programme' => $programme,
            'form' => $form,
        ]);
    }

    #[Route('/back/{id}', name: 'app_programme_showb', methods: ['GET'])]
    public function showb(Programme $programme): Response
    {
        return $this->render('back/programme/show.html.twig', [
            'programme' => $programme,
        ]);
    }

    #[Route('/back/{id}/edit', name: 'app_programme_editb', methods: ['GET', 'POST'])]
    public function editb(Request $request, Programme $programme, EntityManagerInterface $entityManager): Response
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
            $entityManager->persist($programme);
            $entityManager->flush();

            return $this->redirectToRoute('app_programme_indexb', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('back/programme/edit.html.twig', [
            'programme' => $programme,
            'form' => $form,
        ]);
    }

    #[Route('/back/{id}/n', name: 'app_programme_deleteb')]
    public function deleteb(Programme $programme, EntityManagerInterface $entityManager): Response
    {
        $connection = $entityManager->getConnection();

        $entityManager->remove($programme);
        $entityManager->flush();
        $sql = "DELETE FROM `ListExercice` WHERE IDprog = :id";
        $connection->executeQuery($sql, ['id' => $programme->getidprogramme()]);


        return $this->redirectToRoute('app_programme_indexb', [], Response::HTTP_SEE_OTHER);
    }
}
