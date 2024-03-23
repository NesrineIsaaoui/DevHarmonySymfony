<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plan
 *
 * @ORM\Table(name="plan")
 * @ORM\Entity
 */
class Plan
{
    /**
     * @var int
     *
     * @ORM\Column(name="idplan", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idplan;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=10, nullable=false)
     */
    private $nom;

    public function getIdplan(): ?int
    {
        return $this->idplan;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }


}
