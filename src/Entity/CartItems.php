<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItems
 *
 * @ORM\Table(name="cart_items", indexes={@ORM\Index(name="Id_Cart", columns={"Id_Cart"})})
 * @ORM\Entity
 */
class CartItems
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Cart_Item", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCartItem;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_Cart", type="integer", nullable=false)
     */
    private $idCart;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantite", type="integer", nullable=false)
     */
    private $quantite;

    public function getIdCartItem(): ?int
    {
        return $this->idCartItem;
    }

    public function getIdCart(): ?int
    {
        return $this->idCart;
    }

    public function setIdCart(int $idCart): self
    {
        $this->idCart = $idCart;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }


}
