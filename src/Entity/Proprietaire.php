<?php

namespace App\Entity;

use App\Repository\ProprietaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ProprietaireRepository::class)
 * @method string getUserIdentifier()
 * @UniqueEntity(fields={"Email"}, message="There is already an account with this Email")
 */
class Proprietaire implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adresse;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $Pass;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Role;

    /**
     * @ORM\OneToMany(targetEntity=Bien::class, mappedBy="Proprietaire")
     */
    private $biens;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getPass(): ?string
    {
        return $this->Pass;
    }

    public function setPass(string $Pass): self
    {
        $this->Pass = $Pass;

        return $this;
    }

    public function getRole(): ?bool
    {
        return $this->Role;
    }

    public function setRole(bool $Role): self
    {
        $this->Role = $Role;

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
            $bien->setProprietaire($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): self
    {
        if ($this->biens->removeElement($bien)) {
            // set the owning side to null (unless already changed)
            if ($bien->getProprietaire() === $this) {
                $bien->setProprietaire(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {

        if($this->Role == true){
        return ['ROLE_ADMIN'];

        } 
        else if($this->Role == false)
        {
        return ['ROLE_PROPRIO'];
        }

        
    }

    public function getSalt()
    {
        return null;
    }


    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getPassword()
    {
        return $this->getPass();
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->Email,
            $this->Pass
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id, $this->Email, $this->Pass) =
            unserialize($serialized, ["allowed_classes" => false]);
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

}
