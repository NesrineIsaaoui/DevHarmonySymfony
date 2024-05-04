<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Publication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="The title cannot be blank")
     * @Assert\Length(
     *      min=5, 
     *      max=20, 
     *      minMessage="The title must be at least {{ limit }} characters long",
     *      maxMessage="The title cannot be longer than {{ limit }} characters"
     * )
     */
    private string $titre;

    /**
     * @ORM\Column(type="text", length=65535, nullable=false)
     * @Assert\NotBlank(message="The content cannot be blank")
     * @Assert\Length(
     *      min=20, 
     *      max=255, 
     *      minMessage="The content must be at least {{ limit }} characters long",
     *      maxMessage="The content cannot be longer than {{ limit }} characters"
     * )
     */
    private string $contenu;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     */
    private ?User $utilisateur;

    public function __construct()
    {
        $this->datePublication = new \DateTime();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
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

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getContenu();
    }
}
