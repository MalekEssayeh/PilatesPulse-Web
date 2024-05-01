<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/exercice')]
class ExerciceController extends AbstractController
{
    #[Route('/', name: 'app_exercice_index', methods: ['GET'])]
    public function index(ExerciceRepository $exerciceRepository): Response
    {
        return $this->render('exercice/index.html.twig', [
            'exercices' => $exerciceRepository->findAll(),
            'ExerciceRepository' => $exerciceRepository
        ]);
    }

    #[Route('/new', name: 'app_exercice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['Demonstration']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $exercice->setDemonstration($fileName);
            $file = $form['Video']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $exercice->setVideo($fileName);
            $exercice->setIdcoach(123);
            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exercice/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercice_show', methods: ['GET'])]
    public function show(Exercice $exercice): Response
    {
        return $this->render('exercice/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exercice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['Demonstration']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $exercice->setDemonstration($fileName);
            $file = $form['Video']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $exercice->setVideo($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form
        ]);
    }

    #[Route('/{id}/d', name: 'app_exercice_delete', methods: ['GET'])]
    public function delete(Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($exercice);
        $entityManager->flush();

        return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
    }
    /*********************BAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACK*************************/
    #[Route('/back/index', name: 'app_exercice_indexb', methods: ['GET'])]
    public function indexB(ExerciceRepository $exerciceRepository): Response
    {
        return $this->render('BACK/exercice/index.html.twig', [
            'exercices' => $exerciceRepository->findAll(),
            'ExerciceRepository' => $exerciceRepository
        ]);
    }

    #[Route('/back/new', name: 'app_exercice_newb', methods: ['GET', 'POST'])]
    public function newb(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['Demonstration']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $exercice->setDemonstration($fileName);
            $file = $form['Video']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $exercice->setVideo($fileName);
            $exercice->setIdcoach(123);
            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_indexb', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('BACK/exercice/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    #[Route('/back/{id}', name: 'app_exercice_showb', methods: ['GET'])]
    public function showb(Exercice $exercice): Response
    {
        return $this->render('BACK/exercice/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    #[Route('/back/{id}/edit', name: 'app_exercice_editb', methods: ['GET', 'POST'])]
    public function editb(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['Demonstration']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $exercice->setDemonstration($fileName);
            $file = $form['Video']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $exercice->setVideo($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_indexb', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('BACK/exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form
        ]);
    }

    #[Route('/back/{id}/d', name: 'app_exercice_deleteb', methods: ['GET'])]
    public function deleteb(Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($exercice);
        $entityManager->flush();

        return $this->redirectToRoute('app_exercice_indexb', [], Response::HTTP_SEE_OTHER);
    }
}
