<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    #[Route('/base', name: 'app_base')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
    #[Route('/admin', name: 'app_admin')]
    public function indexadmin(): Response
    {
        return $this->render('Admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
}
