<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\Utilisateur;
use App\Form\Commentaire1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/commentaire/back')]
class CommentaireBackController extends AbstractController
{
    #[Route('/', name: 'app_commentaire_back_index', methods: ['GET'])]
    public function index(SessionInterface $session,EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('commentaire_back/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/new', name: 'app_commentaire_back_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session,Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($commentaire);
            $entityManager->flush();

            flash()->addSuccess('New Comment Added Successfully');
            return $this->redirectToRoute('app_commentaire_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire_back/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);

    }
    #[Route('/new/{publication_id}', name: 'app_commentaire_new_2', methods: ['GET', 'POST'])]
    public function new2(SessionInterface $session,Request $request, EntityManagerInterface $entityManager, int $publication_id): Response
    {
        $commentaire = new Commentaire();

        $publication = $entityManager->getRepository(Publication::class)->find($publication_id);

        if ($publication) {
            $commentaire->setPublication($publication);
        }

        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userId = $session->get("user_id");
            $user = $entityManager->find(Utilisateur::class, $userId);
            $commentaire->setUtilisateur($user);

            $entityManager->persist($commentaire);
            $entityManager->flush();

            flash()->addSuccess('New Comment Added Successfully');
            return $this->redirectToRoute('app_commentaire_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire_back/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_commentaire_back_show', methods: ['GET'])]
    public function show(SessionInterface $session,Commentaire $commentaire): Response
    {
        return $this->render('commentaire_back/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentaire_back_edit', methods: ['GET', 'POST'])]
    public function edit(SessionInterface $session,Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();

            flash()->addSuccess('Comment Edited Successfully');
            return $this->redirectToRoute('app_commentaire_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire_back/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_back_delete', methods: ['POST'])]
    public function delete(SessionInterface $session,Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
            flash()->addSuccess('Comment Deleted Successfully');
        }

        return $this->redirectToRoute('app_commentaire_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
