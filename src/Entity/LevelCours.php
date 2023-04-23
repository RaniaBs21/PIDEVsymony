<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $nomLevel;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_c", type="integer", nullable=false)
     */
    private $idC;

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

    public function getIdC(): ?int
    {
        return $this->idC;
    }

    public function setIdC(int $idC): self
    {
        $this->idC = $idC;

        return $this;
    }


}
