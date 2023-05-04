<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="iduser", columns={"id_g"}), @ORM\Index(name="id_g", columns={"id_g"})})
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
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
     * @Assert\NotBlank
     */
    private $titreEv;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_ev", type="string", length=50, nullable=false)
     * @Assert\NotBlank
     */
    private $categorieEv;

    /**
     * @var string
     *
     * @ORM\Column(name="description_ev", type="string", length=200, nullable=false)
     * @Assert\NotBlank
     */
    private $descriptionEv;

    /**
     * 
     * @ORM\Column(name="image_ev", type="blob", length=0, nullable=false)
     * @Assert\NotBlank
     */
    private $imageEv;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_ev", type="string", length=30, nullable=false)
     * @Assert\NotBlank
     */
    private $adresseEv;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=30, nullable=false)
     * @Assert\NotBlank
     */
    private $region;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ev", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     * @Assert\NotBlank
     */
    private $dateEv;

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_places", type="integer", nullable=false)
     * @Assert\NotBlank
     */
    private $nbrePlaces;

    /**
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_g", referencedColumnName="id")
     * })
     */
    private ?Admin $idG = null;

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

    public function getIdG(): ?Admin
    {
        return $this->idG;
    }

    public function setIdG(Admin $idG): self
    {
        $this->idG = $idG;

        return $this;
    }


}
