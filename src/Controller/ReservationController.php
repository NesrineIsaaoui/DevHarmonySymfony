<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Cours;
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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\CategoriecodepromoType;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twilio\Rest\Client;
use Symfony\Component\String\Slugger\SluggerInterface;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
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
        $userId = $session->get("user_id");
        if (!$userId) {
            $this->addFlash('error', 'Please sign up to access our courses.');
        return $this->redirectToRoute('app_user_new');

        }
        $em = $doctrine->getManager();
        $user = $em->find(User::class, $userId);
        $reservation->setIdUser($user);
        $categorieCodePromo = $reservation->getCategoriecodepromos();
        $nbUsers = $categorieCodePromo->getNbUsers();

        if ($nbUsers === 0) {
            $session->set('reservation_message', '');
        } else {
            // Décrémenter le champ nb_users de la catégorie de code promo correspondante
            $categorieCodePromo->setNbUsers($nbUsers - 1);
             // Update the prixd of the reservation based on the selected code promo
             $coursPrix = $reservation->getCourss()->getCoursprix();
             $codePromoValue = $categorieCodePromo->getValue();
             $discountedPrice = $coursPrix - ($coursPrix * ($codePromoValue / 100));
             $reservation->setPrixd($discountedPrice);
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

///////////////////////////////////////////////////////////////////aadmin
    #[Route('/afficher_reservation', name: 'afficher_reservation')]
    public function AfficheReservation (ReservationRepository $repo ,PaginatorInterface $paginator ,Request $request     ): Response
    {
        
        $Reservation=$repo->findAll();
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
    public function panierReservations(ManagerRegistry $doctrine,ReservationRepository $reservationRepo, SessionInterface $session, PaginatorInterface $paginator,Request $request): Response
    {
        $userId = $session->get("user_id");
        if (!$userId) {
            $this->addFlash('error', 'Please sign up to access our courses.');
            return $this->redirectToRoute('app_user_new');

        }
        $em = $doctrine->getManager();
        $user = $em->find(User::class, $userId);
        // Find reservations by user ID
$reservations = $reservationRepo->findBy(['idUser' => $user, 'resstatus' => true, 'paidstatus' => false]);

       // $reservations = $reservationRepo->findBy(['user' => $user,'resstatus' => true, 'paidstatus' => false]);
         $totalAmount = 0;
 foreach ($reservations as $reservation) {
     $totalAmount += $reservation->getPrixd();
 }
        $pagination = $paginator->paginate(
            $reservations,
            $request->query->getInt('page', 1), 
            1 
        );

        return $this->render('reservation/panier_reservations.html.twig', [
            'reservations' => $pagination,
        'totalAmount' => $totalAmount,

        ]);
    }
 

//////////////////////////////////////////////////////////////////////////pay
   #[Route('/process_payment', name: 'process_payment')]
    public function processPayment(ManagerRegistry $doctrine,SessionInterface $session,ReservationRepository $reservationRepo): Response
    {
        $userId = $session->get("user_id");
        $em = $doctrine->getManager();
        $user = $em->find(User::class, $userId);
$reservations = $reservationRepo->findBy(['idUser' => $user, 'resstatus' => true, 'paidstatus' => false]);

       // $reservations = $reservationRepo->findBy(['resstatus' => true, 'paidstatus' => false]);
        $totalAmount = 0;
        foreach ($reservations as $reservation) {
            //$c = $reservation->getCourss();
             $totalAmount += $reservation->getPrixd();
        }
        //$totalAmount = max($totalAmount, 50);
        //$totalAmountCents = $totalAmount * 100; 
        $totalAmountCents = (int)($totalAmount * 100);

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
    public function __construct(private LoggerInterface $logger) {}

    #[Route('/payment_success', name: 'payment_success')]
    public function paymentSuccess(ManagerRegistry $doctrine,SessionInterface $session,ReservationRepository $reservationRepo): Response
    {
        $userId = $session->get("user_id");
        $em = $doctrine->getManager();
        $user = $em->find(User::class, $userId);
$reservations = $reservationRepo->findBy(['idUser' => $user, 'resstatus' => true, 'paidstatus' => false]);

  
        foreach ($reservations as $reservation) {
            $reservation->setPaidStatus(true);
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        //$this->sendSms();
        return $this->redirectToRoute('thank_you');
    }
    #[Route('/send_sms', name: 'send_sms')]
    public function sendSms(): Response
    {
        $reservationDetails = "Thank you for your paiement you are now registred in our cources";

        $twilioAccountSid = $_ENV['TWILIO_ACCOUNT_SID'];
        $twilioAuthToken = $_ENV['TWILIO_AUTH_TOKEN'];
        $twilioPhoneNumber = $_ENV['TWILIO_PHONE_NUMBER'];
        $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);
        $twilioClient->messages->create(
            '+21698125586',
            [
                'from' => $twilioPhoneNumber,
                'body' => $reservationDetails,
            ]
        );
        return new Response('SMS sent successfully');
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
////////////////////////////////////////////////////////////////////////////stat

#[Route('/stat', name: 'stat')]
public function adminStatistics(ReservationRepository $reservationRepo, EntityManagerInterface $entityManager): Response
    {
        $reservations = $reservationRepo->findBy(['paidstatus' => true, 'resstatus' => true]);

        $totalProfit = 0;
        foreach ($reservations as $reservation) {
            $totalProfit += $reservation->getPrixd();
        }

        $coursePurchases = [];
        foreach ($reservations as $reservation) {
            $course = $reservation->getCourss();
            $courseId = $course->getId();

            // Fetch the course entity by its ID
            $courseEntity = $entityManager->getRepository(Cours::class)->find($courseId);
            $courseName = $courseEntity ? $courseEntity->getCoursname() : 'Unknown';

            if (!isset($coursePurchases[$courseName])) {
                $coursePurchases[$courseName] = 0;
            }
            $coursePurchases[$courseName]++;
        }

        return $this->render('reservation/stats.html.twig', [
            'totalProfit' => $totalProfit,
            'coursePurchases' => $coursePurchases,
        ]);
    }


}
