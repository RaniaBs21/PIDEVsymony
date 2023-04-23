<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart", indexes={@ORM\Index(name="Id_Prod", columns={"Id_Prod"}), @ORM\Index(name="iduser", columns={"id"})})
 * @ORM\Entity
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Cart", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCart;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_Prod", type="integer", nullable=false)
     */
    private $idProd;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    public function getIdCart(): ?int
    {
        return $this->idCart;
    }

    public function getIdProd(): ?int
    {
        return $this->idProd;
    }

    public function setIdProd(int $idProd): self
    {
        $this->idProd = $idProd;

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
