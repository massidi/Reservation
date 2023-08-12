<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $equipName = null;

    #[ORM\Column(length: 255)]
    private ?string $equipdescription = null;

    #[ORM\ManyToMany(targetEntity: Chambre::class, mappedBy: 'equipement')]
    private Collection $chambres;



    public function __construct()
    {
        $this->chambres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipName(): ?string
    {
        return $this->equipName;
    }

    public function setEquipName(string $equipName): static
    {
        $this->equipName = $equipName;

        return $this;
    }

    public function getEquipdescription(): ?string
    {
        return $this->equipdescription;
    }

    public function setEquipdescription(string $equipdescription): static
    {
        $this->equipdescription = $equipdescription;

        return $this;
    }

    /**
     * @return Collection<int, Chambre>
     */



    public function __toString(): string
    {
        return  $this->getEquipName();
    }

    /**
     * @return Collection<int, Chambre>
     */
    public function getChambres(): Collection
    {
        return $this->chambres;
    }

    public function addChambre(Chambre $chambre): static
    {
        if (!$this->chambres->contains($chambre)) {
            $this->chambres->add($chambre);
            $chambre->addEquipement($this);
        }

        return $this;
    }

    public function removeChambre(Chambre $chambre): static
    {
        if ($this->chambres->removeElement($chambre)) {
            $chambre->removeEquipement($this);
        }

        return $this;
    }
}
