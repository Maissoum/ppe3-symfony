<?php

namespace App\Entity;

use App\Repository\ActeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActeurRepository::class)]
class Acteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?int $dateNaissance = null;

    #[ORM\ManyToMany(targetEntity: Flm::class, mappedBy: 'acteur')]
    private Collection $flms;

    public function __construct()
    {
        $this->flms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?int
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(int $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection<int, Flm>
     */
    public function getFlms(): Collection
    {
        return $this->flms;
    }

    public function addFlm(Flm $flm): static
    {
        if (!$this->flms->contains($flm)) {
            $this->flms->add($flm);
            $flm->addActeur($this);
        }

        return $this;
    }

    public function removeFlm(Flm $flm): static
    {
        if ($this->flms->removeElement($flm)) {
            $flm->removeActeur($this);
        }

        return $this;
    }
}
