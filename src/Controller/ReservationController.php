<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use App\Repository\CategoriecodepromoRepository;
use App\Entity\Categoriecodepromo;

use App\Form\CategoriecodepromoType;



use Symfony\Component\String\Slugger\SluggerInterface;


use Snipe\BanBuilder\CensorWords;
use Dompdf\Dompdf;
use Dompdf\Options;
class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    //front
   #[Route('/add_reservation', name: 'add_reservation')]
public function Add(
    Request $request,
    ManagerRegistry $doctrine,
    CategoriecodepromoRepository $categorieRepo,
    SessionInterface $session
): Response {
    $reservation = new Reservation();
    $form = $this->createForm(ReservationType::class, $reservation);
    $form->add('Ajouter', SubmitType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $reservation = $form->getData();
        $em = $doctrine->getManager();
        $categorieCodePromo = $reservation->getCategoriecodepromos();
        $nbUsers = $categorieCodePromo->getNbUsers();

        if ($nbUsers === 0) {
            $session->set('reservation_message', '');
        } else {
            // Décrémenter le champ nb_users de la catégorie de code promo correspondante
            $categorieCodePromo->setNbUsers($nbUsers - 1);
            
            // Persistez la réservation
            $em->persist($reservation);
            $em->flush();

            return $this->redirectToRoute('add_reservation');
        }
    }

    return $this->render('reservation/frontadd.html.twig', [
        'form' => $form->createView(),
        'reservation_message' => $session->get('reservation_message')
    ]);
}

//aadmin
    #[Route('/afficher_reservation', name: 'afficher_reservation')]
    public function AfficheReservation (ReservationRepository $repo ,PaginatorInterface $paginator ,Request $request     ): Response
    {
        
        $Reservation=$repo->findAll() ;
        $pagination = $paginator->paginate(
            $Reservation,
            $request->query->getInt('page', 1),
            2 // items per page
        );
        return $this->render('reservation/index.html.twig' , [
            'Reservation' => $pagination ,
            'ajoutA' => $Reservation
        ]) ;
    }


    #[Route('/delete_adh/{id}', name: 'delete_adh')]
    public function Delete($id,ReservationRepository $repository , ManagerRegistry $doctrine) : Response {
        $Reservation=$repository->find($id) ;
        $em=$doctrine->getManager() ;
        $em->remove($Reservation);
        $em->flush();
        return $this->redirectToRoute("add_reservation") ;

    }

    #[Route('/update_adh/{id}', name: 'update_adh')]
    function update(ReservationRepository $repo,$id,Request $request , ManagerRegistry $doctrine){
        $Reservation = $repo->find($id) ;
        $form=$this->createForm(ReservationType::class,$Reservation) ;
        $form->add('update' , SubmitType::class) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted()&& $form->isValid()){
            $Reservation = $form->getData();
            $em=$doctrine->getManager() ;
            $em->flush();
            return $this->redirectToRoute('afficher_reservation') ;
        }
        return $this->render('reservation/update.html.twig' , [
            'form' => $form->createView()
        ]) ;

    }

    #[Route('/panier_reservations', name: 'panier_reservations')]
    public function panierReservations(ReservationRepository $reservationRepo, SessionInterface $session): Response
    {
        $reservations = $reservationRepo->findBy(['resStatus' => true]);

        return $this->render('reservation/panier_reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/process_payment', name: 'process_payment')]
    public function processPayment(ReservationRepository $reservationRepo): Response
    {
        $reservations = $reservationRepo->findBy(['resStatus' => true]);

        $totalAmount = 0;
        foreach ($reservations as $reservation) {
            $c = $reservation->getCourss();
             $totalAmount += $c->getCoursPrix();
        }
        //$totalAmount = max($totalAmount, 50);
        $totalAmountCents = $totalAmount * 100; 
        Stripe::setApiKey('sk_test_51Oj3svCXr5Afrxv4MljO3Ftvb6voQEdB9nctTfpnvuKiy8LvvQGdaP2bQO7LCIhlFhkohFlgTaJtOFFLcWwlJ7bz00d8oFypNE');

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Reservations Payment',
                        ],
                        'unit_amount' => $totalAmountCents, 
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url);
    }

    #[Route('/payment_success', name: 'payment_success')]
    public function paymentSuccess(): Response
    {
       
        return $this->redirectToRoute('thank_you');
    }

    #[Route('/payment_cancel', name: 'payment_cancel')]
    public function paymentCancel(): Response
    {
    
        return $this->redirectToRoute('payment_failure');
    }
    #[Route('/thank_you', name: 'thank_you')]
    public function thankYou(): Response
    {
        return $this->render('payment/thank_you.html.twig');
    }
    
    #[Route('/payment_failure', name: 'payment_failure')]
    public function paymentFailure(): Response
    {
        return $this->render('payment/payment_failure.html.twig');
    }

}
