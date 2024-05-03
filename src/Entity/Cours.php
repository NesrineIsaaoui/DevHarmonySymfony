<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * Cours
 *
 * @ORM\Table(name="cours", indexes={@ORM\Index(name="fk_category", columns={"idCategory"})})
 * @ORM\Entity(repositoryClass=App\Repository\CoursRepository::class)
 */
class Cours
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
     * @var string
     *
     * @ORM\Column(name="coursName", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="cours name ne doit pas être vide.")
 */
    private $coursname;

    /**
     * @var string
     *
     * @ORM\Column(name="coursDescription", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="cours description  ne doit pas être vide.")
     */
    private $coursdescription;

    /**
     * @var string
     *
     * @ORM\Column(name="coursImage", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="selectionner une image.")
     */
    private $coursimage;

    /**
     * @var int
     *
     * @ORM\Column(name="coursPrix", type="integer", nullable=false)
     * @Assert\NotBlank(message="cours prix ")
     * @Assert\Positive(message="prix doit être positive.")
     */
    private $coursprix;

    /**
     * @var \Courscategory
     *
     * @ORM\ManyToOne(targetEntity="Courscategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCategory", referencedColumnName="id")
     * })
     */
    private $idcategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="cours")
     */
    private $avis;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoursname(): ?string
    {
        return $this->coursname;
    }

    public function setCoursname(string $coursname): static
    {
        $this->coursname = $coursname;

        return $this;
    }

    public function getCoursdescription(): ?string
    {
        return $this->coursdescription;
    }

    public function setCoursdescription(string $coursdescription): static
    {
        $this->coursdescription = $coursdescription;

        return $this;
    }

    public function getCoursimage(): ?string
    {
        return $this->coursimage;
    }

    public function setCoursimage(string $coursimage): static
    {
        $this->coursimage = $coursimage;

        return $this;
    }

    public function getCoursprix(): ?int
    {
        return $this->coursprix;
    }

    public function setCoursprix(int $coursprix): static
    {
        $this->coursprix = $coursprix;

        return $this;
    }

    public function getIdcategory(): ?Courscategory
    {
        return $this->idcategory;
    }

    public function setIdcategory(?Courscategory $idcategory): static
    {
        $this->idcategory = $idcategory;

        return $this;
    }


}
