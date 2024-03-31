<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_cours", columns={"id_cours"}), @ORM\Index(name="id_codepromo", columns={"id_codepromo"})})
  * @ORM\Entity(repositoryClass=App\Repository\ReservationRepository::class)
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="resStatus", type="boolean", nullable=false)
     */
    private $resstatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reservation", type="datetime", nullable=false)
     */
    private $dateReservation;

    /**
     * @var float
     *
     * @ORM\Column(name="prixd", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixd;

    /**
     * @var bool
     *
     * @ORM\Column(name="paidStatus", type="boolean", nullable=false)
     */
    private $paidstatus;

    /**
     * @var Cours
     *
     * @ORM\ManyToOne(targetEntity="Cours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cours", referencedColumnName="id")
     * })
     */
    private $idCours;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var Categoriecodepromo
     *@Assert\Valid
     * @ORM\ManyToOne(targetEntity="Categoriecodepromo")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="id_codepromo", referencedColumnName="id")
     * })
     */
    private $idCodepromo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isResstatus(): ?bool
    {
        return $this->resstatus;
    }

    public function setResstatus(bool $resstatus): static
    {
        $this->resstatus = $resstatus;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): static
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getPrixd(): ?float
    {
        return $this->prixd;
    }

    public function setPrixd(float $prixd): static
    {
        $this->prixd = $prixd;

        return $this;
    }

    public function isPaidstatus(): ?bool
    {
        return $this->paidstatus;
    }

    public function setPaidstatus(bool $paidstatus): static
    {
        $this->paidstatus = $paidstatus;

        return $this;
    }

    public function getIdCours(): ?Cours
    {
        return $this->idCours;
    }

    public function setIdCours(?Cours $idCours): static
    {
        $this->idCours = $idCours;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdCodepromo(): ?Categoriecodepromo
    {
        return $this->idCodepromo;
    }

    public function setIdCodepromo(?Categoriecodepromo $idCodepromo): static
    {
        $this->idCodepromo = $idCodepromo;

        return $this;
    }


}
