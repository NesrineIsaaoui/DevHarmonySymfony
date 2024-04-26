<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Form\CoursType;
use App\Form\ReservationType;
use App\Repository\CoursRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Snipe\BanBuilder\CensorWords;


class CoursController extends AbstractController
{



    #[Route('/indexx', name: 'app_indexx')]
    public function indexx(): Response
    {

        return $this->render('client/index.html.twig');
    }

    
    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('admin.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }


    #[Route('/add_cours', name: 'add_cours')]
    public function Add(Request  $request , ManagerRegistry $doctrine ,SluggerInterface $slugger, SessionInterface $session) : Response {
        $Cours =  new Cours() ;
        $form =  $this->createForm(CoursType::class,$Cours) ;
        $form->add('Ajouter' , SubmitType::class) ;
        $form->handleRequest($request) ;
   
        if($form->isSubmitted()&& $form->isValid()){
            $brochureFile = $form->get('image')->getData();
            
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
            $brochureFile->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );
            $Cours->setImage(($newFilename));
            $em= $doctrine->getManager() ;
            $em->persist($Cours);
            $em->flush();
            $coursName = $Cours->getName();

        $notificationMessage = "L'ajout a été effectué pour cet utilisateur, nom de la cours : $coursName";

        $session->getFlashBag()->add('success', $notificationMessage);

            return $this ->redirectToRoute('add_cours') ;
        }
        return $this->render('cours/addcourss.html.twig' , [
            'form' => $form->createView()
        ]) ;
    }


    #[Route('/afficher_formations', name: 'afficher_cours')]
public function AfficheCours(CoursRepository $repo, PaginatorInterface $paginator, Request $request): Response
{
    $courss=$repo->findAll() ;

    $pagination = $paginator->paginate(
        $courss,
        $request->query->getInt('page', 1),
         1
    );
    return $this->render('cours/index.html.twig', [
        'Cours' => $pagination,
        'ajoutA' => $courss
    ]);
}


   #[Route('/afficher_cours2', name: 'afficher_cours2')]
   
public function AfficheCours2(CoursRepository $repo, PaginatorInterface $paginator, Request $request): Response
{
    $courss=$repo->findAll() ;

    $pagination = $paginator->paginate(
        $courss,
        $request->query->getInt('page', 1),
        1 // items per page
    );

    return $this->render('cours/index2.html.twig', [
        'Cours' => $pagination,
        'ajoutA' => $courss
    ]);
}

    #[Route('/delete_ab/{ii}', name: 'delete_ab')]
    public function Delete($id,CoursRepository $repository , ManagerRegistry $doctrine) : Response {
        $Cours=$repository->find($id) ;
        $em=$doctrine->getManager() ;
        $em->remove($Cours);
        $em->flush();
        return $this->redirectToRoute("afficher_cours") ;

    }
    
     #[Route('/delete_av/{id}', name: 'delete_av')]
    public function Delete2($id,CoursRepository $repository , ManagerRegistry $doctrine) : Response {
        $Cours=$repository->find($id) ;
        $em=$doctrine->getManager() ;
        $em->remove($Cours);
        $em->flush();
        return $this->redirectToRoute("afficher_cours2") ;

    }
    #[Route('/update_ab/{id}', name: 'update_ab')]
    function update(CoursRepository $repo,$id,Request $request , ManagerRegistry $doctrine,SluggerInterface $slugger){
        $Cours = $repo->find($id) ;
        $form=$this->createForm(CoursType::class,$Cours) ;
        $form->add('update' , SubmitType::class) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted()&& $form->isValid()){
            $brochureFile = $form->get('image')->getData();
            
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
            
            $brochureFile->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );
            $Cours->setImage(($newFilename));
            $Cours = $form->getData();
            $em=$doctrine->getManager() ;
            $em->flush();
            return $this ->redirectToRoute('afficher_cours') ;
        }
        return $this->render('cours/updatecourss.html.twig' , [
            'form' => $form->createView()
        ]) ;

    }


    #[Route('/update_av/{id}', name: 'update_av')]
    function update2(CoursRepository $repo,$id,Request $request , ManagerRegistry $doctrine,SluggerInterface $slugger){
        $Cours = $repo->find($id) ;
        $form=$this->createForm(CoursType::class,$Cours) ;
        $form->add('update' , SubmitType::class) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted()&& $form->isValid()){
            $brochureFile = $form->get('image')->getData();
            
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
            
            $brochureFile->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );
            $Cours->setImage(($newFilename));
            $Cours = $form->getData();
            $em=$doctrine->getManager() ;
            $em->flush();
            return $this ->redirectToRoute('afficher_cours2') ;
        }
        return $this->render('cours/updatecourss.html.twig' , [
            'form' => $form->createView()
        ]) ;

    }

 
    #[Route('/add_reservation/{id}', name: 'add_reservation')]
public function sendMessage(Request $request, ManagerRegistry $doctrine, SessionInterface $session): Response
{
    // Vérifiez si la variable 'reservation_done' existe dans la session
    if (!$session->has('reservation_done')) {
        // Si elle n'existe pas, initialisez-la à 0
        $session->set('reservation_done', 0);
    }

    $reservation = new Reservation();
    $form = $this->createForm(ReservationType::class, $reservation);
    $form->add('Ajouter', SubmitType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $reservation = $form->getData();
        $em = $doctrine->getManager();
        $em->persist($reservation);
        $em->flush();

        // Mettez à jour la variable dans la session à 1 lorsque la réservation est effectuée
        $session->set('reservation_done', 1);

        return $this->redirectToRoute('add_reservation');
    }

    return $this->render('reservation/frontreserver.html.twig', [
        'form' => $form->createView()
    ]);
}


#[Route('/panier_reservations', name: 'panier_reservations')]
public function panierReservations(ReservationRepository $reservationRepo, SessionInterface $session): Response
{
    $reservationDone = $session->get('reservation_done', 1);

    $reservations = $reservationDone ? $reservationRepo->findBy(['paidStatus' => 0]) : [];

    return $this->render('reservation/panier_reservations.html.twig', [
        'reservations' => $reservations,
    ]);
}


}


