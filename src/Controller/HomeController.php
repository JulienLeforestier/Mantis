<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\MarkRepository;
use App\Repository\TypeRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProducerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository, MarkRepository $markRepository, ProducerRepository $producerRepository): Response
    {
        $products_list = $productRepository->findAll();
        $categories_list = $categoryRepository->findAll();
        $types_list = $typeRepository->findAll();
        $marks_list = $markRepository->findAll();
        $producers_list = $producerRepository->findAll();
        return $this->render('home/index.html.twig', 
        ["products_list" => $products_list, 
         "categories_list" => $categories_list, 
         "types_list" => $types_list,
         "marks_list" => $marks_list,
         "producers_list" => $producers_list,
        ]);
    }

    #[Route('/home/{id}', name: 'home_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('home/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/home', name: 'home_search', methods: ['GET'])]
    public function search(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository, MarkRepository $markRepository, ProducerRepository $producerRepository): Response
    {
        $search = $request->query->get("search");
        $category = $request->query->get("category");
        $type = $request->query->get("type");
        $mark = $request->query->get("mark");
        $producer = $request->query->get("producer");

        if (!is_null($search)){
            $products_list = $productRepository->findBySearch($search);
            $filter = $search;
        }elseif(!is_null($category)){
            $products_list = $categoryRepository->findBySearch($category);
            $filter = $category;
        }elseif(!is_null($type)){
            $products_list = $productRepository->findByType($type);
            $filter = $type;
        }elseif(!is_null($mark)){
            $products_list = $productRepository->findByMark($mark);
            $filter = $mark;
        }elseif(!is_null($producer)){
            $products_list = $productRepository->findByProducer($producer);
            $filter = $producer;
        }

        if (count($products_list) < 1) $this->addFlash("danger", "Aucun produit ne correspond à votre recherche");

        $categories_list = $categoryRepository->findAll();
        $types_list = $typeRepository->findAll();
        $marks_list = $markRepository->findAll();
        $producers_list = $producerRepository->findAll();

        dd($filter, $products_list);

        return $this->render('home/search.html.twig', [
            'products_list' => $products_list,
            "categories_list" => $categories_list, 
            "types_list" => $types_list,
            "marks_list" => $marks_list,
            "producers_list" => $producers_list,
            'search' => $filter,
        ]);
    }
}
