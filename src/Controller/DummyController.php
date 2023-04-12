<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DummyController extends AbstractController
{
    #[Route(path: '/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route(path: '/home')]
    public function home(): Response
    {
        return $this->render('home/home.html.twig');
    }

    #[Route(path: '/blogs')]
    public function blog(): Response
    {
        return $this->render('home/blogs.html.twig');
    }

    #[Route(path: '/about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }

    #[Route(path: '/contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig');
    }
}