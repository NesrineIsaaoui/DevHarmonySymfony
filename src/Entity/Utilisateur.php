<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', nullable: false)]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $prenom;

    #[ORM\Column(type: 'string', length: 12, nullable: false)]
    private string $role;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $motDePasse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?static
    {
       $this->id = $id;
       return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
