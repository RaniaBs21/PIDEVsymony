<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionAss
 *
 * @ORM\Table(name="question_ass", indexes={@ORM\Index(name="Id_Rec", columns={"Id_Rec"}), @ORM\Index(name="idreclamation", columns={"Id_Rec"})})
 * @ORM\Entity
 */
class QuestionAss
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Q_Ass", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idQAss;

    /**
     * @var string
     *
     * @ORM\Column(name="Type_Q_Ass", type="string", length=20, nullable=false)
     */
    private $typeQAss;

    /**
     * @var string
     *
     * @ORM\Column(name="Description_Q_Ass", type="text", length=65535, nullable=false)
     */
    private $descriptionQAss;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_Rec", type="integer", nullable=false)
     */
    private $idRec;

    public function getIdQAss(): ?int
    {
        return $this->idQAss;
    }

    public function getTypeQAss(): ?string
    {
        return $this->typeQAss;
    }

    public function setTypeQAss(string $typeQAss): self
    {
        $this->typeQAss = $typeQAss;

        return $this;
    }

    public function getDescriptionQAss(): ?string
    {
        return $this->descriptionQAss;
    }

    public function setDescriptionQAss(string $descriptionQAss): self
    {
        $this->descriptionQAss = $descriptionQAss;

        return $this;
    }

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function setIdRec(int $idRec): self
    {
        $this->idRec = $idRec;

        return $this;
    }


}
