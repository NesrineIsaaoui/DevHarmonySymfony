<?php

namespace App\Entity;

use App\Repository\CategoriecodepromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CategoriecodepromoRepository::class)]
class Categoriecodepromo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   
#[ORM\Column(type: 'float', nullable: true)]
#[Assert\NotNull (message: "Il faut remplire ce chemp")]
private ?float $value = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull (message: "Il faut remplire ce chemp")]
    private ?string $code = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\NotNull (message: "Il faut remplire ce chemp")]
private ?int $nb_users = null;

    #[ORM\OneToMany(mappedBy: 'categoriecodepromos', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;



    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
{
    return $this->value;
}

public function setValue(?float $value): self
{
    $this->value = $value;

    return $this;
}   
    
    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }



    
    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addCReservationontrat( $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setCategoriecodepromos($this);
        }

        return $this;
    }

    public function removeCReservationontrat( $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getCategoriecodepromos() === $this) {
                $reservation->setCategoriecodepromos(null);
            }
        }

        return $this;
    }
    
public function getNbUsers(): ?int
{
    return $this->nb_users;
}

public function setNbUsers(?int $nb_users): self
{
    $this->nb_users = $nb_users;

    return $this;
}
    
}
