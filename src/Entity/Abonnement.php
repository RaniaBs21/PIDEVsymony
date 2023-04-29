<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement", indexes={@ORM\Index(name="id_transaction", columns={"id_transaction"}), @ORM\Index(name="id_cours", columns={"id_cours"})})
 * @ORM\Entity
 */
class Abonnement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_abon", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAbon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_abon", type="date", nullable=false)
     */
    private $dateAbon;

    /**
     * @var int
     *
     * @ORM\Column(name="id_cours", type="integer", nullable=false)
     */
    private $idCours;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255, nullable=false)
     */
    private $user;

    /**
     * @var \Transaction
     *
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_transaction", referencedColumnName="id")
     * })
     */
    private $idTransaction;

    public function getIdAbon(): ?int
    {
        return $this->idAbon;
    }

    public function getDateAbon(): ?\DateTimeInterface
    {
        return $this->dateAbon;
    }

    public function setDateAbon(\DateTimeInterface $dateAbon): self
    {
        $this->dateAbon = $dateAbon;

        return $this;
    }

    public function getIdCours(): ?int
    {
        return $this->idCours;
    }

    public function setIdCours(int $idCours): self
    {
        $this->idCours = $idCours;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIdTransaction(): ?Transaction
    {
        return $this->idTransaction;
    }

    public function setIdTransaction(?Transaction $idTransaction): self
    {
        $this->idTransaction = $idTransaction;

        return $this;
    }


}
