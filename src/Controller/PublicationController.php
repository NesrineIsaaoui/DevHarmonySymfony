<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use App\Form\CommentaireType;
use App\Form\PublicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/publication')]
class PublicationController extends AbstractController
{
    #[Route('/', name: 'app_publication_index', methods: ['GET'])]
    public function index(SessionInterface $session,EntityManagerInterface $entityManager): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();

        return $this->render('publication/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    #[Route('/mypubs', name: 'app_mypubs', methods: ['GET'])]
    public function mypubs(SessionInterface $session,EntityManagerInterface $entityManager): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();

        return $this->render('publication/mypubs.html.twig', [
            'publications' => $publications,
        ]);
    }

    #[Route('/new', name: 'app_publication_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session,Request $request, EntityManagerInterface $entityManager): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userId = $session->get("user_id");
            $user = $entityManager->find(Utilisateur::class, $userId);
            $publication->setUtilisateur($user);
            $entityManager->persist($publication);
            $entityManager->flush();
            flash()->addSuccess('New Publication Is Out CHECK IT OUT');

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publication_show', methods: ['GET', 'POST'])]
    public function show(SessionInterface $session,Request $request, Publication $publication): Response
    {
        $commentaire = new Commentaire();
        $commentForm = $this->createForm(CommentaireType::class, $commentaire);
        $commentForm->handleRequest($request);
    
        if ($commentForm->isSubmitted() && $commentForm->isValid()) { 
            $entityManager = $this->getDoctrine()->getManager();
            $commentaire->setPublication($publication);
            $entityManager->persist($commentaire);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_publication_show', ['id' => $publication->getId()]);
        }
    
        $comments = $this->getDoctrine()->getRepository(Commentaire::class)->findBy(['publication' => $publication]);
    
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),
        ]);
    }
    


    #[Route('/{id}/edit', name: 'app_publication_edit', methods: ['GET', 'POST'])]
    public function edit(SessionInterface $session,Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userId = $session->get("user_id");
            $user = $entityManager->find(Utilisateur::class, $userId);
            $publication->setUtilisateur($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publication_delete', methods: ['POST'])]
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $publication->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
            flash()->addSuccess('Blog Deleted Successfully');
        }

        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
