<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer", nullable: false)]
    private int $id;

    #[ORM\Column(type: "text", length: 255, nullable: false)]
    #[Assert\NotBlank(message:"The contenu cannot be blank")]
    private string $contenu;

    #[ORM\Column(type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTimeInterface $dateCommentaire;

    #[ORM\ManyToOne(targetEntity: "Publication")]
    #[ORM\JoinColumn(name: "publication_id", referencedColumnName: "id")]
    private ?Publication $publication;

    #[ORM\ManyToOne(targetEntity: "Utilisateur")]
    #[ORM\JoinColumn(name: "utilisateur_id", referencedColumnName: "id")]
    private ?Utilisateur $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->dateCommentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $dateCommentaire): static
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): static
    {
        $this->publication = $publication;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }


}
