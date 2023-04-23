<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $dateCmd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Liv", type="date", nullable=false)
     */
    private $dateLiv;

    /**
     * @var \Cart
     *
     * @ORM\ManyToOne(targetEntity="Cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Cart", referencedColumnName="Id_Cart")
     * })
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

    public function getIdCart(): ?Cart
    {
        return $this->idCart;
    }

    public function setIdCart(?Cart $idCart): self
    {
        $this->idCart = $idCart;

        return $this;
    }


}
