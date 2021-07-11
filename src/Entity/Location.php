<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $DateArrive;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrJourPiscineAdulte;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrJourPiscineEnfant;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrEnfant;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrAdulte;

    /**
     * @ORM\ManyToOne(targetEntity=Bien::class, inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Bien;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="locations",cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->DateArrive;
    }

    public function setDateArrive(\DateTimeInterface $DateArrive): self
    {
        $this->DateArrive = $DateArrive;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getNbrJourPiscineAdulte(): ?int
    {
        return $this->nbrJourPiscineAdulte;
    }

    public function setNbrJourPiscineAdulte(int $nbrJourPiscineAdulte): self
    {
        $this->nbrJourPiscineAdulte = $nbrJourPiscineAdulte;

        return $this;
    }

    public function getNbrJourPiscineEnfant(): ?int
    {
        return $this->nbrJourPiscineEnfant;
    }

    public function setNbrJourPiscineEnfant(int $nbrJourPiscineEnfant): self
    {
        $this->nbrJourPiscineEnfant = $nbrJourPiscineEnfant;

        return $this;
    }

    public function getNbrEnfant(): ?int
    {
        return $this->nbrEnfant;
    }

    public function setNbrEnfant(int $nbrEnfant): self
    {
        $this->nbrEnfant = $nbrEnfant;

        return $this;
    }

    public function getNbrAdulte(): ?int
    {
        return $this->nbrAdulte;
    }

    public function setNbrAdulte(int $nbrAdulte): self
    {
        $this->nbrAdulte = $nbrAdulte;

        return $this;
    }

    public function getBien(): ?Bien
    {
        return $this->Bien;
    }

    public function setBien(?Bien $Bien): self
    {
        $this->Bien = $Bien;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }
}
