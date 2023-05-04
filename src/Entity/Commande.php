<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fk_commande_cart", columns={"Id_Cart"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Cmd", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCmd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Cmd", type="date", nullable=false)
     * @Assert\GreaterThanOrEqual("today", message="La date de commande ne peut pas être ultérieure à aujourd'hui")
    */
    private $dateCmd;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Liv", type="date", nullable=false)
     * @Assert\GreaterThan(propertyPath="dateCmd", message="La date de livraison doit être ultérieure à la date de commande")
    */
    private $dateLiv;


    /**
    * @var int|null
    * @ORM\Column(name="Id_Cart", type="integer", nullable=true)
    */
    private $idCart;

    public function getIdCmd(): ?int
    {
        return $this->idCmd;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->dateCmd;
    }

    public function setDateCmd(\DateTimeInterface $dateCmd): self
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    public function getDateLiv(): ?\DateTimeInterface
    {
        return $this->dateLiv;
    }

    public function setDateLiv(\DateTimeInterface $dateLiv): self
    {
        $this->dateLiv = $dateLiv;

        return $this;
    }

    public function getIdCart(): ?int
    {
        return $this->idCart;
    }

    public function setIdCart(?int $idCart): self
    {
        $this->idCart = $idCart;

        return $this;
    }


}
