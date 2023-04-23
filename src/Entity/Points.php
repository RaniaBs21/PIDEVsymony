<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Points
 *
 * @ORM\Table(name="points", indexes={@ORM\Index(name="iduser", columns={"id"})})
 * @ORM\Entity
 */
class Points
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_points", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPoints;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer", nullable=false)
     */
    private $score;

    /**
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    public function getIdPoints(): ?int
    {
        return $this->idPoints;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getId(): ?Admin
    {
        return $this->id;
    }

    public function setId(?Admin $id): self
    {
        $this->id = $id;

        return $this;
    }


}
