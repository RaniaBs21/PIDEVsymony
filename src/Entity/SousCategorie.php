<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $nomSc;

    /**
     * @var int
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     */
    private $idCategorie;

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


}
