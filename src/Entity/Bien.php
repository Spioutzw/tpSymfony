<?php

namespace App\Entity;

use App\Repository\BienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BienRepository::class)
 */
class Bien
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="Bien")
     */
    private $locations;

    /**
     * @ORM\ManyToOne(targetEntity=Proprietaire::class, inversedBy="biens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Proprietaire;

    /**
     * @ORM\ManyToOne(targetEntity=TypeBien::class, inversedBy="biens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Type;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setBien($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getBien() === $this) {
                $location->setBien(null);
            }
        }

        return $this;
    }

    public function getProprietaire(): ?Proprietaire
    {
        return $this->Proprietaire;
    }

    public function setProprietaire(?Proprietaire $Proprietaire): self
    {
        $this->Proprietaire = $Proprietaire;

        return $this;
    }

    public function getType(): ?TypeBien
    {
        return $this->Type;
    }

    public function setType(?TypeBien $Type): self
    {
        $this->Type = $Type;

        return $this;
    }
}
