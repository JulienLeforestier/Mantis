<?php

namespace App\Controller;

use App\Entity\Notice;
use App\Entity\Product;
use App\Form\NoticeType;
use App\Form\NoticeByUserType;
use App\Repository\NoticeRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoticeController extends AbstractController
{
    #[Route('/admin/notice', name: 'notice_index', methods: ['GET'])]
    public function index(NoticeRepository $noticeRepository): Response
    {
        return $this->render('notice/index.html.twig', [
            'notices' => $noticeRepository->findAll(),
        ]);
    }

    #[Route('/admin/notice/new', name: 'notice_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $notice = new Notice();
        $form = $this->createForm(NoticeType::class, $notice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notice);
            $entityManager->flush();

            return $this->redirectToRoute('notice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notice/new.html.twig', [
            'notice' => $notice,
            'form' => $form,
        ]);
    }

    #[Route('/notice/new/{id}', name: 'notice_new_by_user', methods: ['GET', 'POST'])]
    public function newByUser(Request $request, $id): Response
    {
        $notice = new Notice();
        $form = $this->createForm(NoticeByUserType::class, $notice);
        $product = new Product();
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        $notice->setProduct($product);
        $notice->setUser($this->getUser());
        $notice->setRegistrationDate(new \DateTime('now'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notice);
            $entityManager->flush();

            return $this->redirectToRoute('notice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notice/new_by_user.html.twig', [
            'notice' => $notice,
            'form' => $form,
        ]);
    }

    #[Route('/notice/{id}', name: 'notice_show_all', methods: ['GET'])]
    public function show_all(NoticeRepository $noticeRepository, ProductRepository $productRepository, $id): Response
    {
        return $this->render('notice/show_all.html.twig', [
            'product' => $productRepository->find($id),
            'notices' => $noticeRepository->findByProduct($id),
        ]);
    }

    #[Route('/admin/notice/{id}', name: 'notice_show', methods: ['GET'])]
    public function show(Notice $notice): Response
    {
        return $this->render('notice/show.html.twig', [
            'notice' => $notice,
        ]);
    }

    #[Route('/admin/notice/{id}/edit', name: 'notice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Notice $notice): Response
    {
        $form = $this->createForm(NoticeType::class, $notice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notice/edit.html.twig', [
            'notice' => $notice,
            'form' => $form,
        ]);
    }

    #[Route('/admin/notice/{id}', name: 'notice_delete', methods: ['POST'])]
    public function delete(Request $request, Notice $notice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($notice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notice_index', [], Response::HTTP_SEE_OTHER);
    }
}
