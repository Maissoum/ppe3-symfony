<?php

namespace App\Entity;

use App\Repository\FlmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlmRepository::class)]
class Flm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $dateSorti = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\ManyToMany(targetEntity: Cat::class, mappedBy: 'films')]
    private Collection $cats;

    #[ORM\OneToMany(mappedBy: 'flms', targetEntity: Avis::class)]
    private Collection $aviss;

    public function __construct()
    {
        $this->cats = new ArrayCollection();
        $this->aviss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

        public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateSorti(): ?int
    {
        return $this->dateSorti;
    }

    public function setDateSorti(int $dateSorti): static
    {
        $this->dateSorti = $dateSorti;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return Collection<int, Cat>
     */
    public function getCats(): Collection
    {
        return $this->cats;
    }

    public function addCat(Cat $cat): static
    {
        if (!$this->cats->contains($cat)) {
            $this->cats->add($cat);
            $cat->addFilm($this);
        }

        return $this;
    }

    public function removeCat(Cat $cat): static
    {
        if ($this->cats->removeElement($cat)) {
            $cat->removeFilm($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAviss(): Collection
    {
        return $this->aviss;
    }

    public function addAviss(Avis $aviss): static
    {
        if (!$this->aviss->contains($aviss)) {
            $this->aviss->add($aviss);
            $aviss->setFlms($this);
        }

        return $this;
    }

    public function removeAviss(Avis $aviss): static
    {
        if ($this->aviss->removeElement($aviss)) {
            // set the owning side to null (unless already changed)
            if ($aviss->getFlms() === $this) {
                $aviss->setFlms(null);
            }
        }

        return $this;
    }
}
