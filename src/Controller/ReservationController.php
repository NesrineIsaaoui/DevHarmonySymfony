<?php

namespace App\Controller;
use App\Form\PromoCodeType;
use App\Entity\Categoriecodepromo;
use App\Entity\User;
use App\Entity\Reservation;
use App\Entity\Cours; 
use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function addToCart(int $id, Cart $cartService): Response
    {
        $id=36;
        $course = $this->getDoctrine()->getRepository(Cours::class)->find($id);
    
        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }
    
        
        $userId = 52;
    
        // Fetch the User entity corresponding to the user ID
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($userId);
    
        // Create a new reservation
        $reservation = new Reservation();
        $reservation->setIdCours($course);
        $reservation->setDateReservation(new \DateTime());
        $reservation->setResstatus(false);
        $reservation->setPaidstatus(false);
        // Set the User entity as the user for the reservation
        $reservation->setIdUser($user);
        
        $reservation->setPrixd($course->getCoursprix());
        $cartService->addToCart($reservation);
    
        return $this->redirectToRoute('cart_show');
    }
    
    


    #[Route('/cart', name: 'cart_show')]
    public function showCart(Cart $cartService): Response
    {
        $cartData = $cartService->getFullCart();

        return $this->render('cart/show.html.twig', [
            'cartData' => $cartData,
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function removeFromCart(int $id, Cart $cartService): Response
    {
        $cartService->removeFromCart($id);

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/apply-promo', name: 'apply_promo', methods: ['GET', 'POST'])]
    public function applyPromo(Request $request): Response
    {
        $form = $this->createForm(PromoCodeType::class);
        $form->handleRequest($request);
    
        $error = null; 
        $success = null; 
    
        if ($form->isSubmitted() && $form->isValid()) {
            $promoCode = $form->getData()['promo_code'];
    
           
            $promoCodeEntity = $this->getDoctrine()->getRepository(Categoriecodepromo::class)->findOneBy(['code' => $promoCode]);
    
            if ($promoCodeEntity && $promoCodeEntity->getNbusers() > 0) {
                $success = 'Promo code applied successfully.';
            } else {
                $error = 'Invalid promo code.';
            }
        }
    
        return $this->render('cart/promo_code_form.html.twig', [
            'form' => $form->createView(),
            'error' => $error, 
            'success' => $success, 
        ]);
    }
    
}
