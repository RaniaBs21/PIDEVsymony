<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sujet
 *
 * @ORM\Table(name="sujet", indexes={@ORM\Index(name="fk_iduser", columns={"id"}), @ORM\Index(name="fk_idtopic", columns={"idtopic"})})
 * @ORM\Entity
 */
class Sujet
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsujet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsujet;

    /**
     * @var string
     *
     * @ORM\Column(name="titresujet", type="string", length=255, nullable=false)
     */
    private $titresujet;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="accepter", type="integer", nullable=false)
     */
    private $accepter;

    /**
     * @var int
     *
     * @ORM\Column(name="nbcom", type="integer", nullable=false)
     */
    private $nbcom;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idtopic", type="integer", nullable=false)
     */
    private $idtopic;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="blob", length=0, nullable=false)
     */
    private $photo;

    public function getIdsujet(): ?int
    {
        return $this->idsujet;
    }

    public function getTitresujet(): ?string
    {
        return $this->titresujet;
    }

    public function setTitresujet(string $titresujet): self
    {
        $this->titresujet = $titresujet;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAccepter(): ?int
    {
        return $this->accepter;
    }

    public function setAccepter(int $accepter): self
    {
        $this->accepter = $accepter;

        return $this;
    }

    public function getNbcom(): ?int
    {
        return $this->nbcom;
    }

    public function setNbcom(int $nbcom): self
    {
        $this->nbcom = $nbcom;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getIdtopic(): ?int
    {
        return $this->idtopic;
    }

    public function setIdtopic(int $idtopic): self
    {
        $this->idtopic = $idtopic;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }


}
