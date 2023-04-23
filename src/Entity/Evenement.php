<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="iduser", columns={"id_g"}), @ORM\Index(name="id_g", columns={"id_g"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_ev", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEv;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_ev", type="string", length=100, nullable=false)
     */
    private $titreEv;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_ev", type="string", length=50, nullable=false)
     */
    private $categorieEv;

    /**
     * @var string
     *
     * @ORM\Column(name="description_ev", type="string", length=200, nullable=false)
     */
    private $descriptionEv;

    /**
     * @var string
     *
     * @ORM\Column(name="image_ev", type="blob", length=0, nullable=false)
     */
    private $imageEv;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_ev", type="string", length=30, nullable=false)
     */
    private $adresseEv;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=30, nullable=false)
     */
    private $region;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ev", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateEv = 'CURRENT_TIMESTAMP';

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_places", type="integer", nullable=false)
     */
    private $nbrePlaces;

    /**
     * @var int
     *
     * @ORM\Column(name="id_g", type="integer", nullable=false)
     */
    private $idG;

    public function getIdEv(): ?int
    {
        return $this->idEv;
    }

    public function getTitreEv(): ?string
    {
        return $this->titreEv;
    }

    public function setTitreEv(string $titreEv): self
    {
        $this->titreEv = $titreEv;

        return $this;
    }

    public function getCategorieEv(): ?string
    {
        return $this->categorieEv;
    }

    public function setCategorieEv(string $categorieEv): self
    {
        $this->categorieEv = $categorieEv;

        return $this;
    }

    public function getDescriptionEv(): ?string
    {
        return $this->descriptionEv;
    }

    public function setDescriptionEv(string $descriptionEv): self
    {
        $this->descriptionEv = $descriptionEv;

        return $this;
    }

    public function getImageEv()
    {
        return $this->imageEv;
    }

    public function setImageEv($imageEv): self
    {
        $this->imageEv = $imageEv;

        return $this;
    }

    public function getAdresseEv(): ?string
    {
        return $this->adresseEv;
    }

    public function setAdresseEv(string $adresseEv): self
    {
        $this->adresseEv = $adresseEv;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDateEv(): ?\DateTimeInterface
    {
        return $this->dateEv;
    }

    public function setDateEv(\DateTimeInterface $dateEv): self
    {
        $this->dateEv = $dateEv;

        return $this;
    }

    public function getNbrePlaces(): ?int
    {
        return $this->nbrePlaces;
    }

    public function setNbrePlaces(int $nbrePlaces): self
    {
        $this->nbrePlaces = $nbrePlaces;

        return $this;
    }

    public function getIdG(): ?int
    {
        return $this->idG;
    }

    public function setIdG(int $idG): self
    {
        $this->idG = $idG;

        return $this;
    }


}
