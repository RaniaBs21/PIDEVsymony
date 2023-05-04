<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;


/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="idev", columns={"id_ev"}), @ORM\Index(name="iduser", columns={"Id_Ut"})})
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRepository")
 */
class Participation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_part", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPart;

    /**
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Ut", referencedColumnName="id")
     * })
     */
    private ?Admin $idU = null;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ev", referencedColumnName="id_ev")
     * })
     */
    private $idEv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_participation", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateParticipation = 'CURRENT_TIMESTAMP';

    public function getIdPart(): ?int
    {
        return $this->idPart;
    }

    public function getIdU(): ?Admin
    {
        return $this->idU;
    }

    public function setIdU(Admin $idU): self
    {
        $this->idU = $idU;

        return $this;
    }

    public function getIdEv(): ?Evenement
    {
        return $this->idEv;
    }

    public function setIdEv(?Evenement $idEv): self
    {
        $this->idEv = $idEv;

        return $this;
    }


    public function getDateParticipation(): ?\DateTimeInterface
    {
        return $this->dateParticipation;
    }

    public function setDateParticipation(\DateTimeInterface $dateParticipation): self
    {
        $this->dateParticipation = $dateParticipation;

        return $this;
    }

    public function __construct()
    {
        $this->dateParticipation = new DateTime('now');
    }
    

}
