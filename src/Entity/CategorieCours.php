<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CategorieCours
 *
 * @ORM\Table(name="categorie_cours")
 * @ORM\Entity
 */
class CategorieCours
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_cat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCat;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_cat", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Nom est obligatoire")
     * @Assert\Length(min=1, max=255, minMessage="Titre doit contenir au moins {{ limit }} caractère", maxMessage="Titre doit contenir au maximum {{ limit }} caractères")
     
     */
    private $nomCat;

    public function getIdCat(): ?int
    {
        return $this->idCat;
    }

    public function getNomCat(): ?string
    {
        return $this->nomCat;
    }

    public function setNomCat(string $nomCat): self
    {
        $this->nomCat = $nomCat;

        return $this;
    }


}
