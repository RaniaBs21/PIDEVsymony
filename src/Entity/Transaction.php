<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_At", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="nom_carte", type="string", length=255, nullable=false)
     */
    private $nomCarte;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_carte", type="string", length=255, nullable=false)
     */
    private $numeroCarte;

    /**
     * @var int
     *
     * @ORM\Column(name="exp_mois", type="integer", nullable=false)
     */
    private $expMois;

    /**
     * @var int
     *
     * @ORM\Column(name="exp_annee", type="integer", nullable=false)
     */
    private $expAnnee;

    /**
     * @var int
     *
     * @ORM\Column(name="cvc", type="integer", nullable=false)
     */
    private $cvc;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentIntent_id", type="string", length=255, nullable=false)
     */
    private $paymentintentId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNomCarte(): ?string
    {
        return $this->nomCarte;
    }

    public function setNomCarte(string $nomCarte): self
    {
        $this->nomCarte = $nomCarte;

        return $this;
    }

    public function getNumeroCarte(): ?string
    {
        return $this->numeroCarte;
    }

    public function setNumeroCarte(string $numeroCarte): self
    {
        $this->numeroCarte = $numeroCarte;

        return $this;
    }

    public function getExpMois(): ?int
    {
        return $this->expMois;
    }

    public function setExpMois(int $expMois): self
    {
        $this->expMois = $expMois;

        return $this;
    }

    public function getExpAnnee(): ?int
    {
        return $this->expAnnee;
    }

    public function setExpAnnee(int $expAnnee): self
    {
        $this->expAnnee = $expAnnee;

        return $this;
    }

    public function getCvc(): ?int
    {
        return $this->cvc;
    }

    public function setCvc(int $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }

    public function getPaymentintentId(): ?string
    {
        return $this->paymentintentId;
    }

    public function setPaymentintentId(string $paymentintentId): self
    {
        $this->paymentintentId = $paymentintentId;

        return $this;
    }


}
