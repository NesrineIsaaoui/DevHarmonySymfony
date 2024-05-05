<?php

namespace App\Controller;

use App\Entity\Categoriecodepromo;
use App\Form\Categoriecodepromo1Type;
use App\Repository\CategoriecodepromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categoriecodepromo')]
class CategoriecodepromoController extends AbstractController
{
    #[Route('/', name: 'app_categoriecodepromo_index', methods: ['GET'])]
    public function index(CategoriecodepromoRepository $categoriecodepromoRepository): Response
    {
        return $this->render('categoriecodepromo/index.html.twig', [
            'categoriecodepromos' => $categoriecodepromoRepository->findAll(),
        ]);
    }
    
    #[Route('/new', name: 'app_categoriecodepromo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoriecodepromo = new Categoriecodepromo();
        $form = $this->createForm(Categoriecodepromo1Type::class, $categoriecodepromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categoriecodepromo);
            $entityManager->flush();
            $this->addFlash(
                'notice', 'Your discount code has been added!'
            );
            return $this->redirectToRoute('app_categoriecodepromo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categoriecodepromo/new.html.twig', [
            'categoriecodepromo' => $categoriecodepromo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categoriecodepromo_show', methods: ['GET'])]
    public function show(Categoriecodepromo $categoriecodepromo): Response
    {
        return $this->render('categoriecodepromo/show.html.twig', [
            'categoriecodepromo' => $categoriecodepromo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categoriecodepromo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categoriecodepromo $categoriecodepromo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Categoriecodepromo1Type::class, $categoriecodepromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'noticeupdate', 'Your discount code has been edited!'
            );
            return $this->redirectToRoute('app_categoriecodepromo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categoriecodepromo/edit.html.twig', [
            'categoriecodepromo' => $categoriecodepromo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categoriecodepromo_delete', methods: ['POST'])]
    public function delete(Request $request, Categoriecodepromo $categoriecodepromo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoriecodepromo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categoriecodepromo);
            $entityManager->flush();
            $this->addFlash(
                'noticedelete', 'Your discount code has been deleted!'
            );
        }

        return $this->redirectToRoute('app_categoriecodepromo_index', [], Response::HTTP_SEE_OTHER);
    }
}
