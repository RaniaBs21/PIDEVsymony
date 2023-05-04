<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormTypeInterface ;

/**
 * LevelCours
 *
 * @ORM\Table(name="level_cours", indexes={@ORM\Index(name="cours", columns={"Id_c"})})
 * @ORM\Entity
 */
class LevelCours
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_level", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLevel;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_level", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Nom est obligatoire")
     * @Assert\Length(min=1, max=255, minMessage="Titre doit contenir au moins {{ limit }} caractère", maxMessage="Titre doit contenir au maximum {{ limit }} caractères")
     
     */
     
    private $nomLevel;

  

    public function getIdLevel(): ?int
    {
        return $this->idLevel;
    }

    public function getNomLevel(): ?string
    {
        return $this->nomLevel;
    }

    public function setNomLevel(string $nomLevel): self
    {
        $this->nomLevel = $nomLevel;

        return $this;
    }

    

}
