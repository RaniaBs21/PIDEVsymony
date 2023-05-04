<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Titre est obligatoire")
     * @Assert\Length(min=1, max=255, minMessage="Titre doit contenir au moins {{ limit }} caractère", maxMessage="Titre doit contenir au maximum {{ limit }} caractères")
     */
 
    private $titreC;


     /**
     * @var SousCategorie
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SousCategorie", inversedBy="cours")
     * @ORM\JoinColumn(name="Sous_categorie", referencedColumnName="ID_sc")
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
      * @Assert\File(
     *  mimeTypes = {"image/jpeg", "image/png"},
     *  mimeTypesMessage = "Veuillez insérer une image valide de type JPEG ou PNG ."
     * )
     */
    private $fichierC;

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;


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
     * @Assert\GreaterThanOrEqual(1, message="Le prix ne peut pas être négatif ou nulle ")
     */
     
    private $prix;

    
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

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sousCategorie;
    }

     public function setSousCategorie(?SousCategorie $sousCategorie): self
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
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

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

    public function __construct()
    {
        $this->dateC = new DateTime('now');
    }

    public function getImageData()
    {
        return stream_get_contents($this->fichierC);
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

  

    public function getId(): int {
        return $this->idC;
    }

}
