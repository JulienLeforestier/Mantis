<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository): Response
    {
        $products_list = $productRepository->findAll();
        return $this->render('home/index.html.twig', ["products_list" => $products_list]);
    }

    #[Route('/home/{id}', name: 'home_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('home/show.html.twig', [
            'product' => $product,
        ]);
    }
}
