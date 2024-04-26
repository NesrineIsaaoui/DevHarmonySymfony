<?php

namespace App\Controller;
use App\Entity\Categoriecodepromo;
use App\Entity\Reservation;
use App\Form\CategoriecodepromoType;
use App\Form\ReservationType;
use App\Repository\CategoriecodepromoRepository;
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


class CategoriecodepromoController extends AbstractController
{



    #[Route('/indexx', name: 'app_indexx')]
    public function indexx(): Response
    {

        return $this->render('client/index.html.twig');
    }


    #[Route('/categoriecodepromo', name: 'app_categoriecodepromo')]
    public function index(): Response
    {
        return $this->render('admin.html.twig', [
            'controller_name' => 'CategoriecodepromoController',
        ]);
    }

    #[Route('/add_categoriecodepromo', name: 'add_categoriecodepromo')]

    public function Add(Request  $request , ManagerRegistry $doctrine ,SluggerInterface $slugger, SessionInterface $session) : Response {

        $Categoriecodepromo =  new Categoriecodepromo() ;
        $form =  $this->createForm(CategoriecodepromoType::class,$Categoriecodepromo) ;
        $form->add('Ajouter' , SubmitType::class) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted()&& $form->isValid()){     
            $em= $doctrine->getManager() ;
            $em->persist($Categoriecodepromo);
            $em->flush();
            $categoriecodepromoCode = $Categoriecodepromo->getCode();

        // Créer le message de notification
        $notificationMessage = "L'ajout a été effectué pour cet utilisateur, nom de la categoriecodepromo : $categoriecodepromoCode";

        // Ajouter la notification à la session flash
        $session->getFlashBag()->add('success', $notificationMessage);

            return $this ->redirectToRoute('add_categoriecodepromo') ;
        }
        return $this->render('categoriecodepromo/addcategoriecodepromos.html.twig' , [
            'form' => $form->createView()
        ]) ;
    }

    #[Route('/afficher_categoriecodepromo', name: 'afficher_categoriecodepromo')]
   
public function AfficheCategoriecodepromo(CategoriecodepromoRepository $repo, PaginatorInterface $paginator, Request $request): Response
{
    $categoriecodepromos=$repo->findAll() ;

    $pagination = $paginator->paginate(
        $categoriecodepromos,
        $request->query->getInt('page', 1),
        1 // items per page
    );

    return $this->render('categoriecodepromo/index.html.twig', [
        'Categoriecodepromo' => $pagination,
        'ajoutA' => $categoriecodepromos
    ]);
}

    #[Route('/delete_av/{id}', name: 'delete_av')]
    public function Delete($id,CategoriecodepromoRepository $repository , ManagerRegistry $doctrine) : Response {
        $Categoriecodepromo=$repository->find($id) ;
        $em=$doctrine->getManager() ;
        $em->remove($Categoriecodepromo);
        $em->flush();
        return $this->redirectToRoute("afficher_categoriecodepromo") ;

    }
    #[Route('/update_av/{id}', name: 'update_av')]
    function update(CategoriecodepromoRepository $repo,$id,Request $request , ManagerRegistry $doctrine,SluggerInterface $slugger){
        $Categoriecodepromo = $repo->find($id) ;
        $form=$this->createForm(CategoriecodepromoType::class,$Categoriecodepromo) ;
        $form->add('update' , SubmitType::class) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted()&& $form->isValid()){
           

            $Categoriecodepromo = $form->getData();
            $em=$doctrine->getManager() ;
            $em->flush();
            return $this ->redirectToRoute('afficher_categoriecodepromo') ;
        }
        return $this->render('categoriecodepromo/updatecategoriecodepromos.html.twig' , [
            'form' => $form->createView()
        ]) ;

    }

}


