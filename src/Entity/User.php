<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    private int $id;

    #[ORM\Column(name: "nom", type: "string", length: 15, nullable: false)]
    #[Assert\NotBlank(message: "Please enter a name.")]
    #[Assert\Length(max: 15, maxMessage: "Name must be at most {{ limit }} characters long.")]
    private ?string $nom;

    #[ORM\Column(name: "prenom", type: "string", length: 15, nullable: false)]
    #[Assert\NotBlank(message: "Please enter a last name.")]
    #[Assert\Length(max: 15, maxMessage: "Last name must be at most {{ limit }} characters long.")]
    private ?string $prenom;

    #[ORM\Column(name: "age", type: "integer", nullable: true)]
    #[Assert\Range(min: 8, minMessage: "Age must be at least {{ limit }}.")]
    private ?int $age;

    #[ORM\Column(name: "image", type: "string", length: 255, nullable: true)]
    private ?string $image;

    #[ORM\Column(name: "num_tel", type: "integer", nullable: true)]
    private ?int $numTel;

    #[ORM\Column(name: "email", type: "string", length: 50, nullable: false, unique: true)]
    #[Assert\NotBlank(message: "Please enter a password.")]
    #[Assert\Length(min: 6, max: 100, minMessage: "Password must be at least {{ limit }} characters long.")]
    private ?string $email;

    #[ORM\Column(name: "mdp", type: "string", length: 100, nullable: false)]
    #[Assert\NotBlank(message: "Please enter a password.")]
    #[Assert\Length(min: 6, max: 100, minMessage: "Password must be at least {{ limit }} characters long.")]
    private ?string $mdp;

    #[ORM\Column(name: "status", type: "string", length: 20, nullable: false)]
    private ?string $status = "Active";

    #[ORM\Column(name: "resetcode", type: "integer", nullable: true)]
    private ?int $resetcode;

    #[ORM\Column(name: "confirmcode", type: "string", length: 25, nullable: true)]
    private ?string $confirmcode;

    #[ORM\Column(name: "statuscode", type: "integer", nullable: true)]
    private ?int $statuscode;

    #[ORM\Column(name: "role", type: "string", length: 15, nullable: false)]
    private $role = "Client";

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->numTel;
    }

    public function setNumTel(?int $numTel): self
    {
        $this->numTel = $numTel;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getResetcode(): ?int
    {
        return $this->resetcode;
    }

    public function setResetcode(?int $resetcode): self
    {
        $this->resetcode = $resetcode;
        return $this;
    }

    public function getConfirmcode(): ?string
    {
        return $this->confirmcode;
    }

    public function setConfirmcode(?string $confirmcode): self
    {
        $this->confirmcode = $confirmcode;
        return $this;
    }

    public function getStatuscode(): ?int
    {
        return $this->statuscode;
    }

    public function setStatuscode(?int $statuscode): self
    {
        $this->statuscode = $statuscode;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom . ' ' . $this->prenom;
    }
}
