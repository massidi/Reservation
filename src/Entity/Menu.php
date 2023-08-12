<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $menuName = null;

    #[ORM\Column(length: 255)]
    private ?string $menudescription = null;

    #[ORM\Column(length: 255)]
    private ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'menus')]
    private ?Restaurant $restaurant = null;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Rcommande::class)]
    private Collection $rcommandes;

    public function __construct()
    {
        $this->rcommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenuName(): ?string
    {
        return $this->menuName;
    }

    public function setMenuName(string $menuName): static
    {
        $this->menuName = $menuName;

        return $this;
    }

    public function getMenudescription(): ?string
    {
        return $this->menudescription;
    }

    public function setMenudescription(string $menudescription): static
    {
        $this->menudescription = $menudescription;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): static
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * @return Collection<int, Rcommande>
     */
    public function getRcommandes(): Collection
    {
        return $this->rcommandes;
    }

    public function addRcommande(Rcommande $rcommande): static
    {
        if (!$this->rcommandes->contains($rcommande)) {
            $this->rcommandes->add($rcommande);
            $rcommande->setMenu($this);
        }

        return $this;
    }

    public function removeRcommande(Rcommande $rcommande): static
    {
        if ($this->rcommandes->removeElement($rcommande)) {
            // set the owning side to null (unless already changed)
            if ($rcommande->getMenu() === $this) {
                $rcommande->setMenu(null);
            }
        }

        return $this;
    }
}
