<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likee
 *
 * @ORM\Table(name="likee", indexes={@ORM\Index(name="fk_user", columns={"id"}), @ORM\Index(name="fk_com", columns={"id_commentaire"})})
 * @ORM\Entity
 */
class Likee
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_like", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLike;

    /**
     * @var int|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin", inversedBy="likee")
     * @ORM\JoinColumn(nullable=true)
     */
    private $id;

    /**
     * @var int|null
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Commentaire", inversedBy="likee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCommentaire;

    /**
     * @var int
     *
     * @ORM\Column(name="nblike", type="integer", nullable=true)
     */
    private $nblike = '0';

    public function getIdLike(): ?int
    {
        return $this->idLike;
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

    public function getIdCommentaire(): ?int
    {
        return $this->idCommentaire;
    }

    public function setIdCommentaire(?int $idCommentaire): self
    {
        $this->idCommentaire = $idCommentaire;

        return $this;
    }

    public function getNblike(): ?int
    {
        return $this->nblike;
    }

    public function setNblike(int $nblike): self
    {
        $this->nblike = $nblike;

        return $this;
    }

}
