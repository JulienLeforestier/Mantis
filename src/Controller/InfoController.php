<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/info')]
class InfoController extends AbstractController
{
    #[Route('/contact', name: 'contact', methods: ['GET'])]
    public function contact(): Response
    {
        return $this->render('info/contact.html.twig');
    }

    #[Route('/gtc', name: 'gtc', methods: ['GET'])]
    public function gtc(): Response
    {
        return $this->render('info/gtc.html.twig');
    }

    #[Route('/legal_mentions', name: 'legal_mentions', methods: ['GET'])]
    public function legal_mentions(): Response
    {
        return $this->render('info/legal_mentions.html.twig');
    }

    #[Route('/who_we_are', name: 'who_we_are', methods: ['GET'])]
    public function who_we_are(): Response
    {
        return $this->render('info/who_we_are.html.twig');
    }
}
