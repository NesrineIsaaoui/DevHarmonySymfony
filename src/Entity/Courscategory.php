<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Courscategory
 *
 * @ORM\Table(name="courscategory")
 * @ORM\Entity(repositoryClass=App\Repository\CourscategoryRepository::class)
 */
class Courscategory
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
     * @ORM\Column(name="categoryName", type="string", length=255, nullable=false)
     */
    private $categoryname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryname(): ?string
    {
        return $this->categoryname;
    }

    public function setCategoryname(string $categoryname): static
    {
        $this->categoryname = $categoryname;

        return $this;
    }


}
