<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categoriecodepromo
 *
 * @ORM\Table(name="categoriecodepromo")
 * @ORM\Entity(repositoryClass=App\Repository\CategoriecodepromoRepository::class)
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
     */
    private $code;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=false)
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_users", type="integer", nullable=false)
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
