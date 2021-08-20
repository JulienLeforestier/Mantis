<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Command;
use App\Entity\CommandLine;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(Session $session): Response
    {
        $cart = $session->get("cart");
        return $this->render('cart/index.html.twig', compact("cart"));
    }

    #[Route('/cart/add/{id}', name: 'cart_add', requirements: ['id' => '\d+'])]
    public function add(Request $request, Session $session, Product $product): Response
    {
        $quantity = (int)$request->query->get("quantity");
        $quantity = empty($quantity) ? 1 : $quantity;
        $cart = $session->get("cart", []);
        $productExiste = false;
        foreach ($cart as $key => $line) {
            if ($product->getId() == $line["product"]->getId()) {
                $cart[$key]["quantity"] += $quantity;
                $productExiste = true;
            }
        }
        if (!$productExiste) $cart[] = ["product" => $product, "quantity" => $quantity];
        $session->set("cart", $cart);
        $this->addFlash("success", "Le produit " . $product->getTitle() . " a bien été ajouté $quantity fois à votre panier");
        return $this->redirectToRoute('home');
    }

    #[Route('/cart/delete/{id}', name: 'cart_delete', requirements: ['id' => '\d+'])]
    public function delete(Session $session, Product $product): Response
    {
        $cart = $session->get("cart", []);
        foreach ($cart as $key => $line) {
            if ($product->getId() == $line["product"]->getId()) {
                unset($cart[$key]);
                break;
            }
        }
        $session->set("cart", $cart);
        $this->addFlash("success", "Le produit " . $product->getTitle() . " a bien été retiré de votre panier");
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/empty', name: 'cart_empty')]
    public function empty(Session $session): Response
    {
        $session->remove("cart");
        $this->addFlash("success", "Le panier a été vidé");
        return $this->redirectToRoute('home');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/cart/confirm', name: 'cart_confirm')]
    public function confirm(Session $session, EntityManagerInterface $em, productRepository $productRepository): Response
    {
        $cart = $session->get("cart");
        $command = new Command;
        $command->setUser($this->getUser());
        $command->setRegistrationDate(new \DateTime());
        $command->setStatus("en attente");
        $amount = 0;
        $totalAmount = 0;
        foreach ($cart as $line) {
            $amount = $line["product"]->getPrice() * $line["quantity"];
            $totalAmount += $line["product"]->getPrice() * $line["quantity"];
            $command_line = new CommandLine;
            $command_line->setCommand($command);
            $product = $productRepository->find($line["product"]->getId());
            $command_line->setproduct($product);
            $command_line->setQuantity($line["quantity"]);
            $command_line->setPrice($amount);
            $em->persist($command_line);
            $product->setStock($product->getStock() - $line["quantity"]);
        }
        $command->setAmount($totalAmount);
        $em->persist($command);
        $em->flush();
        $session->remove("cart");

        $this->addFlash("success", "Le panier a été validé, nous commençons à préparer votre commande");
        return $this->redirectToRoute('home');
    }
}
