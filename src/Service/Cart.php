<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface; 
class Cart
{
    private $session;
    private $reservationRepository;
    private $entityManager; 

    public function __construct(SessionInterface $session, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->reservationRepository = $reservationRepository;
        $this->entityManager = $entityManager;  
    }

    public function addToCart(Reservation $reservation)
    { 
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();
        $cart = $this->getCart();
        $reservationId = $reservation->getId();
        $cart[$reservationId] = 1;
        $this->updateCart($cart);
    }

    public function removeFromCart(int $reservationId)
    {
        $cart = $this->getCart();
        unset($cart[$reservationId]);
        $this->updateCart($cart);
    }

    public function getFullCart()
    {
        $cart = $this->getCart();
        $fullCart = ['reservations' => []];

        foreach ($cart as $reservationId => $quantity) {
            $reservation = $this->reservationRepository->find($reservationId);
            if ($reservation) {
                $fullCart['reservations'][] = [
                    'reservation' => $reservation,
                    'quantity' => $quantity,
                ];
            }
        }

        return $fullCart;
    }

    private function updateCart($cart)
    {
        $this->session->set('cart', $cart);
    }

    private function getCart()
    {
        return $this->session->get('cart', []);
    }
}
