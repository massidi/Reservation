<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Vich\Uploadable]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $chamtype = null;

    #[ORM\Column(length: 255)]
    private ?string $chamdescription = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?int $nbrlit = null;

    #[ORM\OneToMany(mappedBy: 'chambre', targetEntity: Reservation::class,fetch: "LAZY")]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'chambres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $hotel = null;

    #[ORM\ManyToOne(inversedBy: 'chambres')]
    private ?CategorieChambre $CategorieChambre = null;

    #[ORM\ManyToMany(targetEntity: Equipement::class, inversedBy: 'chambres')]
    private Collection $equipement;


    #[ORM\OneToMany(mappedBy: 'chambre', targetEntity: Images::class ,cascade: ['persist'])]
    private Collection $Images;


    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->equipement = new ArrayCollection();
        $this->Images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChamtype(): ?string
    {
        return $this->chamtype;
    }

    public function setChamtype(string $chamtype): static
    {
        $this->chamtype = $chamtype;

        return $this;
    }

    public function getChamdescription(): ?string
    {
        return $this->chamdescription;
    }

    public function setChamdescription(string $chamdescription): static
    {
        $this->chamdescription = $chamdescription;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNbrlit(): ?int
    {
        return $this->nbrlit;
    }

    public function setNbrlit(int $nbrlit): static
    {
        $this->nbrlit = $nbrlit;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setChambre($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getChambre() === $this) {
                $reservation->setChambre(null);
            }
        }

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getCategorieChambre(): ?CategorieChambre
    {
        return $this->CategorieChambre;
    }

    public function setCategorieChambre(?CategorieChambre $CategorieChambre): static
    {
        $this->CategorieChambre = $CategorieChambre;

        return $this;
    }


    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipement(): Collection
    {
        return $this->equipement;
    }

    public function addEquipement(Equipement $equipement): static
    {
        if (!$this->equipement->contains($equipement)) {
            $this->equipement->add($equipement);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): static
    {
        $this->equipement->removeElement($equipement);

        return $this;
    }

    public function getImages(): ?Collection
    {
        return $this->Images;
    }


    public function addImage(Images $image): static
    {
        if (!$this->Images->contains($image)) {
            $this->Images->add($image);
            $image->setChambre($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->Images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getChambre() === $this) {
                $image->setChambre(null);
            }
        }

        return $this;
    }
}
