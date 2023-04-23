<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReponseUtilisateur
 *
 * @ORM\Table(name="reponse_utilisateur", indexes={@ORM\Index(name="iduser", columns={"id"}), @ORM\Index(name="idquiz", columns={"id_quiz"}), @ORM\Index(name="idquest", columns={"id_quest"})})
 * @ORM\Entity
 */
class ReponseUtilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rep", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRep;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=100, nullable=false)
     */
    private $reponse;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_quiz", type="integer", nullable=false)
     */
    private $idQuiz;

    /**
     * @var int
     *
     * @ORM\Column(name="id_quest", type="integer", nullable=false)
     */
    private $idQuest;

    public function getIdRep(): ?int
    {
        return $this->idRep;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

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

    public function getIdQuiz(): ?int
    {
        return $this->idQuiz;
    }

    public function setIdQuiz(int $idQuiz): self
    {
        $this->idQuiz = $idQuiz;

        return $this;
    }

    public function getIdQuest(): ?int
    {
        return $this->idQuest;
    }

    public function setIdQuest(int $idQuest): self
    {
        $this->idQuest = $idQuest;

        return $this;
    }


}
