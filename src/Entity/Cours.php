<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours", indexes={@ORM\Index(name="Sous_categorie", columns={"Sous_categorie"}), @ORM\Index(name="utilisateur", columns={"id"})})
 * @ORM\Entity
 */
class Cours
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_c", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idC;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre_c", type="string", length=255, nullable=false)
     */
    private $titreC;

    /**
     * @var int
     *
     * @ORM\Column(name="Sous_categorie", type="integer", nullable=false)
     */
    private $sousCategorie;

    /**
     * @var int
     *
     * @ORM\Column(name="Niveau_c", type="integer", nullable=false)
     */
    private $niveauC;

    /**
     * @var string
     *
     * @ORM\Column(name="Fichier_c", type="blob", length=0, nullable=false)
     */
    private $fichierC;

    /**
     * @var string
     *
     * @ORM\Column(name="Description_c", type="text", length=0, nullable=false)
     */
    private $descriptionC;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_c", type="date", nullable=false)
     */
    private $dateC;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    public function getIdC(): ?int
    {
        return $this->idC;
    }

    public function getTitreC(): ?string
    {
        return $this->titreC;
    }

    public function setTitreC(string $titreC): self
    {
        $this->titreC = $titreC;

        return $this;
    }

    public function getSousCategorie(): ?int
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(int $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    public function getNiveauC(): ?int
    {
        return $this->niveauC;
    }

    public function setNiveauC(int $niveauC): self
    {
        $this->niveauC = $niveauC;

        return $this;
    }

    public function getFichierC()
    {
        return $this->fichierC;
    }

    public function setFichierC($fichierC): self
    {
        $this->fichierC = $fichierC;

        return $this;
    }

    public function getDescriptionC(): ?string
    {
        return $this->descriptionC;
    }

    public function setDescriptionC(string $descriptionC): self
    {
        $this->descriptionC = $descriptionC;

        return $this;
    }

    public function getDateC(): ?\DateTimeInterface
    {
        return $this->dateC;
    }

    public function setDateC(\DateTimeInterface $dateC): self
    {
        $this->dateC = $dateC;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }


}
