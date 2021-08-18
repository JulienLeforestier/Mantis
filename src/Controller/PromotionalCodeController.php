<?php

namespace App\Controller;

use App\Entity\PromotionalCode;
use App\Form\PromotionalCodeType;
use App\Repository\PromotionalCodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/promotional_code')]
class PromotionalCodeController extends AbstractController
{
    #[Route('/', name: 'promotional_code_index', methods: ['GET'])]
    public function index(PromotionalCodeRepository $promotionalCodeRepository): Response
    {
        return $this->render('promotional_code/index.html.twig', [
            'promotional_codes' => $promotionalCodeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'promotional_code_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $promotionalCode = new PromotionalCode();
        $form = $this->createForm(PromotionalCodeType::class, $promotionalCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotionalCode);
            $entityManager->flush();

            return $this->redirectToRoute('promotional_code_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotional_code/new.html.twig', [
            'promotional_code' => $promotionalCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'promotional_code_show', methods: ['GET'])]
    public function show(PromotionalCode $promotionalCode): Response
    {
        return $this->render('promotional_code/show.html.twig', [
            'promotional_code' => $promotionalCode,
        ]);
    }

    #[Route('/{id}/edit', name: 'promotional_code_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PromotionalCode $promotionalCode): Response
    {
        $form = $this->createForm(PromotionalCodeType::class, $promotionalCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotional_code_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotional_code/edit.html.twig', [
            'promotional_code' => $promotionalCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'promotional_code_delete', methods: ['POST'])]
    public function delete(Request $request, PromotionalCode $promotionalCode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotionalCode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($promotionalCode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('promotional_code_index', [], Response::HTTP_SEE_OTHER);
    }
}
