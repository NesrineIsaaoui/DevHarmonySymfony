<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Categoriecodepromo
 *
 * @ORM\Table(name="categoriecodepromo")
 * @ORM\Entity(repositoryClass=App\Repository\CategoriecodepromoRepository::class)
 * @UniqueEntity(fields={"code"}, message="This code is already in use.")
 */
class Categoriecodepromo
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
     * @ORM\Column(name="code", type="string", length=200, nullable=false)
     * @Assert\NotBlank(message="Code should not be blank")
     */
    private $code;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Value should not be blank")
     * @Assert\Type(type="float", message="Value should be a float")
     * @Assert\Range(
     *      min = 0.1,
     *      max = 0.9,
     *      minMessage = "Value must be at least 0.1",
     *      maxMessage = "Value cannot be greater than 0.9"
     * )
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_users", type="integer", nullable=false)
     * @Assert\NotBlank(message="Number of users should not be blank")
     * @Assert\Type(type="integer", message="Number of users should be an integer")
     */
    private $nbUsers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getNbUsers(): ?int
    {
        return $this->nbUsers;
    }

    public function setNbUsers(int $nbUsers): static
    {
        $this->nbUsers = $nbUsers;

        return $this;
    }


}
