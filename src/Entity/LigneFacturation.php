<?php

namespace App\Entity;

use App\Repository\LigneFacturationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneFacturationRepository::class)
 */
class LigneFacturation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="float")
     */
    private $Prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $Reference;

    /**
     * @ORM\ManyToOne(targetEntity=Facturation::class, inversedBy="ligneFacturations", cascade={"persist", "remove"})
     */
    private $Facture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getReference(): ?int
    {
        return $this->Reference;
    }

    public function setReference(int $Reference): self
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getFacture(): ?Facturation
    {
        return $this->Facture;
    }

    public function setFacture(?Facturation $Facture): self
    {
        $this->Facture = $Facture;

        return $this;
    }
}
