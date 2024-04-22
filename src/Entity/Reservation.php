<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CategoriecodepromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan("now", message: "La date doit être postérieure à aujourd'hui")]
    public ?\DateTimeInterface $date_reservation = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $resStatus = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $paidStatus = null;
  
    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoriecodepromo $categoriecodepromos = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $courss = null;



    public function getId(): ?int
    {
        return $this->id;
    }
    public function getResStatus(): ?bool
{
    return $this->resStatus;
}

public function setResStatus(?bool $resStatus): self
{
    $this->resStatus = $resStatus;
    return $this;
}

// Méthodes d'accès pour prixd


// Méthodes d'accès pour paidStatus
public function getPaidStatus(): ?bool
{
    return $this->paidStatus;
}

public function setPaidStatus(?bool $paidStatus): self
{
    $this->paidStatus = $paidStatus;
    return $this;
}

    public function getCategoriecodepromos(): ?Categoriecodepromo
    {
        return $this->categoriecodepromos;
    }

    public function setCategoriecodepromos(?categoriecodepromo $s): self
    {
        $this->categoriecodepromos = $s;

        return $this;
   }
   public function getCourss(): ?Cours
    {
        return $this->courss;
    }

    public function setCourss(?cours $s): self
    {
        $this->courss = $s;

        return $this;
   }
  
   public function getDate_reservation(): ?\DateTimeInterface
    {
        return $this->date_reservation;
    }

    public function setDate_reservation(\DateTimeInterface $date_reservation): self
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

   



   
   
}
