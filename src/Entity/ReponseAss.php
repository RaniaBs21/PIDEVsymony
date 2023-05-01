<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * ReponseAss
 *
 * @ORM\Table(name="reponse_ass", indexes={@ORM\Index(name="idreclamation", columns={"Id_Rec"})})
 * @ORM\Entity
 */
class ReponseAss
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Rep_Ass", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRepAss;

    /**
     * @var string
     *
     * @ORM\Column(name="Type_Rep_Ass", type="string", length=20, nullable=false)
     */
    private $typeRepAss;

    /**
     * @var string
     *
     * @ORM\Column(name="Que_Rep_Ass", type="text", length=65535, nullable=false)
     */
    private $queRepAss;

    /**
     * @var string
     *
     * @ORM\Column(name="Description_Rep_Ass", type="text", length=65535, nullable=false)
     */
    private $descriptionRepAss;


    public function getIdRepAss(): ?int
    {
        return $this->idRepAss;
    }

    public function getTypeRepAss(): ?string
    {
        return $this->typeRepAss;
    }

    public function setTypeRepAss(string $typeRepAss): self
    {
        $this->typeRepAss = $typeRepAss;

        return $this;
    }

    public function getQueRepAss(): ?string
    {
        return $this->queRepAss;
    }

    public function setQueRepAss(string $queRepAss): self
    {
        $this->queRepAss = $queRepAss;

        return $this;
    }

    public function getDescriptionRepAss(): ?string
    {
        return $this->descriptionRepAss;
    }

    public function setDescriptionRepAss(string $descriptionRepAss): self
    {
        $this->descriptionRepAss = $descriptionRepAss;

        return $this;
    }


}