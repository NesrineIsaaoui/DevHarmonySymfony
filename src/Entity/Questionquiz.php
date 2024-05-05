<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Questionquiz
 *
 * @ORM\Table(name="questionquiz", indexes={@ORM\Index(name="fk_idquiz_questionquiz", columns={"id_quiz"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\QuestionquizRepository")
 */
class Questionquiz
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="veuillez renseigner la question ")
     * @Groups("post:read")
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_correcte", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="veuillez renseigner la reponse correcte ")
     * @Groups("post:read")
     */
    private $reponseCorrecte;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_fausse1", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="veuillez renseigner la proposition 1")
     * @Groups("post:read")
     */
    private $reponseFausse1;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_fausse2", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="veuillez renseigner la proposition 2")
     * @Groups("post:read")
     */
    private $reponseFausse2;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_fausse3", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="veuillez renseigner la proposition 3")
     * @Groups("post:read")
     */
    private $reponseFausse3;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     *@Assert\NotBlank(message="veuillez entrer le nbre de points pour la question")
     *@Assert\GreaterThan(value = -1,message = "point doit etre positif")
     * @Groups("post:read")
     */
    private $note;

    /**
     * @var \Quiz
     *
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="questions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_quiz", referencedColumnName="id")
     * })
     * @Groups("post:read")
     */
    private $idQuiz;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getReponseCorrecte(): ?string
    {
        return $this->reponseCorrecte;
    }

    public function setReponseCorrecte(?string $reponseCorrecte): self
    {
        $this->reponseCorrecte = $reponseCorrecte;

        return $this;
    }

    public function getReponseFausse1(): ?string
    {
        return $this->reponseFausse1;
    }

    public function setReponseFausse1(?string $reponseFausse1): self
    {
        $this->reponseFausse1 = $reponseFausse1;

        return $this;
    }

    public function getReponseFausse2(): ?string
    {
        return $this->reponseFausse2;
    }

    public function setReponseFausse2(?string $reponseFausse2): self
    {
        $this->reponseFausse2 = $reponseFausse2;

        return $this;
    }

    public function getReponseFausse3(): ?string
    {
        return $this->reponseFausse3;
    }

    public function setReponseFausse3(?string $reponseFausse3): self
    {
        $this->reponseFausse3 = $reponseFausse3;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getIdQuiz(): ?Quiz
    {
        return $this->idQuiz;
    }

    public function setIdQuiz(?Quiz $idQuiz): self
    {
        $this->idQuiz = $idQuiz;

        return $this;
    }


}
