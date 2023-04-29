<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Points
 *
 * @ORM\Table(name="points")
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
     * @var Admin
     **@ORM\ManyToOne(targetEntity="App\Entity\Admin", inversedBy="points")
     * @ORM\Column(name="id", type="integer",nullable=false)
     */
    private $id;

    private $admin;
    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }


    public function getIdPoints(): ?int
    {
        return $this->idPoints;
    }
    public function setIdPoints(int $idPoints): self
    {
        $this->idPoints = $idPoints;

        return $this;

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
