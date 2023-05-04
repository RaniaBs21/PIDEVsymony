<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SousCategorie
 *
 * @ORM\Table(name="sous_categorie", indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"})})
 * @ORM\Entity
 */
class SousCategorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_sc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSc;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_sc", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=1, max=255, minMessage="Le nom doit contenir au moins {{ limit }} caractère", maxMessage="Titre doit contenir au maximum {{ limit }} caractères")
     */
    private $nomSc;

    /**
     * @var int
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     */
    private $idCategorie;

    /**
     * @var CategorieCours
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieCours")
     * @ORM\JoinColumn(name="id_categorie", referencedColumnName="Id_cat")
     */
    private $categorieCours;

    public function getIdSc(): ?int
    {
        return $this->idSc;
    }

    public function getNomSc(): ?string
    {
        return $this->nomSc;
    }

    public function setNomSc(string $nomSc): self
    {
        $this->nomSc = $nomSc;

        return $this;
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(int $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getCategorieCours(): ?CategorieCours
    {
        return $this->categorieCours;
    }

    public function setCategorieCours(?CategorieCours $categorieCours): self
    {
        $this->categorieCours = $categorieCours;

        return $this;
    }

}
