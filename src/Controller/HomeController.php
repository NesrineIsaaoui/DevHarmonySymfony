<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(SessionInterface $session): Response
    {
        $session->set('user_id', 2);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/back', name: 'app_home_back')]
    public function indexBack(SessionInterface $session,CommentaireRepository $commentaireRepository, PublicationRepository $publicationRepository): Response
    {
        $commentCount = $commentaireRepository->count([]);
        $publicationCount = $publicationRepository->count([]);

        return $this->render('home/indexBack.html.twig', [
            'commentCount' => $commentCount,
            'publicationCount' => $publicationCount,
        ]);
    }

}
