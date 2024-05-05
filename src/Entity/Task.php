<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use DateTime;
use App\Entity\Plan;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    *@Assert\NotBlank(message="veuillez saisir un nom de cour") 
    *@Assert\Length(
    *min = 2,
    *minMessage=" Entrer un nom de cour au mini de 2 caracteres"
    *
    * )
    *@ORM\Column(type="string", length=20)
    */

    private $nomcour;

/**
 * @ORM\Column(type="datetime")
 */
private $date;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=plan::class, inversedBy="tasks")
     * @ORM\JoinColumn(name="id_plan", referencedColumnName="id" , nullable=false)
     */
    private $idPlan;

    /**
 * @Assert\Callback
 */


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomcour(): ?string
    {
        return $this->nomcour;
    }

    public function setNomcour(string $nomcour): self
    {
        $this->nomcour = $nomcour;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdplan(): ?Plan
    {
        return $this->idPlan;
    }

    public function setIdplan(?Plan $idPlan): self
    {
        $this->idPlan = $idPlan;

        return $this;
    }
}
