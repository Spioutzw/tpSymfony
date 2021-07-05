<?php

namespace App\Entity;

use App\Repository\TypeBienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeBienRepository::class)
 */
class TypeBien
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
    private $Label;

    /**
     * @ORM\Column(type="integer")
     */
    private $Prix;

    /**
     * @ORM\OneToMany(targetEntity=Bien::class, mappedBy="Type")
     */
    private $biens;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getLabel();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->Label;
    }

    public function setLabel(string $Label): self
    {
        $this->Label = $Label;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    /**
     * @return Collection|Bien[]
     */
    public function getBiens(): Collection
    {
        return $this->biens;
    }

    public function addBien(Bien $bien): self
    {
        if (!$this->biens->contains($bien)) {
            $this->biens[] = $bien;
            $bien->setType($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): self
    {
        if ($this->biens->removeElement($bien)) {
            // set the owning side to null (unless already changed)
            if ($bien->getType() === $this) {
                $bien->setType(null);
            }
        }

        return $this;
    }
}
