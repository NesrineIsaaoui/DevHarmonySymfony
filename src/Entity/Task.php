<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task", indexes={@ORM\Index(name="idplan", columns={"idplan"})})
 * @ORM\Entity
 */
class Task
{
    /**
     * @var int
     *
     * @ORM\Column(name="idtask", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtask;

    /**
     * @var string
     *
     * @ORM\Column(name="nomcour", type="string", length=10, nullable=false)
     */
    private $nomcour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=10, nullable=false, options={"default"="en attente"})
     */
    private $etat = 'en attente';

    /**
     * @var \Plan
     *
     * @ORM\ManyToOne(targetEntity="Plan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplan", referencedColumnName="idplan")
     * })
     */
    private $idplan;

    public function getIdtask(): ?int
    {
        return $this->idtask;
    }

    public function getNomcour(): ?string
    {
        return $this->nomcour;
    }

    public function setNomcour(string $nomcour): static
    {
        $this->nomcour = $nomcour;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdplan(): ?Plan
    {
        return $this->idplan;
    }

    public function setIdplan(?Plan $idplan): static
    {
        $this->idplan = $idplan;

        return $this;
    }


}
