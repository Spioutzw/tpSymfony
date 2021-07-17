<?php

namespace App\Entity;

use App\Repository\FacturationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=FacturationRepository::class)
 * 
 */
class Facturation
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
    private $dateFacturation;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroIdentification;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="facturations", cascade={"persist", "remove"})
     */
    private $Client;

    /**
     * @ORM\OneToMany(targetEntity=LigneFacturation::class, mappedBy="Facture")
     */
    private $ligneFacturations;



    public function __toString(): string
    {
      return $this->getClient();
    }

    public function __construct()
    {
        $this->ligneFacturations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFacturation(): ?\DateTimeInterface
    {
        return $this->dateFacturation;
    }

    public function setDateFacturation(\DateTimeInterface $dateFacturation): self
    {
        $this->dateFacturation = $dateFacturation;

        return $this;
    }

    public function getNumeroIdentification(): ?int
    {
        return $this->numeroIdentification;
    }

    public function setNumeroIdentification(int $numeroIdentification): self
    {
        $this->numeroIdentification = $numeroIdentification;

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

    /**
     * @return Collection|LigneFacturation[]
     */
    public function getLigneFacturations(): Collection
    {
        return $this->ligneFacturations;
    }

    public function addLigneFacturation(LigneFacturation $ligneFacturation): self
    {
        if (!$this->ligneFacturations->contains($ligneFacturation)) {
            $this->ligneFacturations[] = $ligneFacturation;
            $ligneFacturation->setFacture($this);
        }

        return $this;
    }

    public function removeLigneFacturation(LigneFacturation $ligneFacturation): self
    {
        if ($this->ligneFacturations->removeElement($ligneFacturation)) {
            // set the owning side to null (unless already changed)
            if ($ligneFacturation->getFacture() === $this) {
                $ligneFacturation->setFacture(null);
            }
        }

        return $this;
    }

   

}
