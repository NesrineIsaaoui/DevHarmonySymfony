<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le champ de description du cours ne peut pas être vide")]
    #[Assert\Length(max: 255, maxMessage: "La description du cours ne peut pas dépasser {{ limit }} caractères")]
    private ?string $coursDescription = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le champ de nom du cours ne peut pas être vide")]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le champ de prix du cours ne peut pas être vide")]
    #[Assert\Regex(
        pattern: '/^\d+(\.\d{1,2})?$/',
        message: "Le prix du cours doit être un nombre avec maximum 2 décimales"
    )]
    #[Assert\GreaterThanOrEqual(value: 0, message: "Le prix du cours ne peut pas être négatif")]
    private ?string $coursPrix = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'image ne peut pas être vide")]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'courss', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoursDescription(): ?string
    {
        return $this->coursDescription;
    }

    public function setCoursDescription(string $coursDescription): self
    {
        $this->coursDescription = $coursDescription;

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
            $reservation->setCourss($this);
        }

        return $this;
    }

    public function removeCReservationontrat( $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getCourss() === $this) {
                $reservation->setCourss(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }
    public function getCoursPrix(): ?string
    {
        return $this->coursPrix;
    }

    public function setCoursPrix(string $coursPrix): self
    {
        $this->coursPrix = $coursPrix;

        return $this;
    }
    
   

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    
}
