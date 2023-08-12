<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $hotelnom = null;

    #[ORM\Column(length: 255)]
    private ?string $hoteladresse = null;

    #[ORM\Column(length: 255)]
    private ?string $hoteldescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hotelclasse = null;

    #[ORM\OneToMany(mappedBy: 'hotel', targetEntity: Chambre::class)]
    private Collection $chambres;

    public function __construct()
    {
        $this->chambres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHotelnom(): ?string
    {
        return $this->hotelnom;
    }

    public function setHotelnom(string $hotelnom): static
    {
        $this->hotelnom = $hotelnom;

        return $this;
    }

    public function getHoteladresse(): ?string
    {
        return $this->hoteladresse;
    }

    public function setHoteladresse(string $hoteladresse): static
    {
        $this->hoteladresse = $hoteladresse;

        return $this;
    }

    public function getHoteldescription(): ?string
    {
        return $this->hoteldescription;
    }

    public function setHoteldescription(string $hoteldescription): static
    {
        $this->hoteldescription = $hoteldescription;

        return $this;
    }

    public function getHotelclasse(): ?string
    {
        return $this->hotelclasse;
    }

    public function setHotelclasse(?string $hotelclasse): static
    {
        $this->hotelclasse = $hotelclasse;

        return $this;
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
            $chambre->setHotel($this);
        }

        return $this;
    }

    public function removeChambre(Chambre $chambre): static
    {
        if ($this->chambres->removeElement($chambre)) {
            // set the owning side to null (unless already changed)
            if ($chambre->getHotel() === $this) {
                $chambre->setHotel(null);
            }
        }

        return $this;
    }
}
