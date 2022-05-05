<?php

namespace App\Entity;

use App\Repository\CampagneRecolteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRecolteRepository::class)]
class CampagneRecolte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateDebut;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateFin;

    #[ORM\Column(type: 'float', nullable: true)]
    private $surfaceTotal;

    #[ORM\Column(type: 'float', nullable: true)]
    private $surfaceRecolte;

    #[ORM\Column(type: 'float', nullable: true)]
    private $quantiteRecolte;

    #[ORM\OneToMany(mappedBy: 'campagneRecolte', targetEntity: Recolte::class)]
    private $parcelles;

    public function __construct()
    {
        $this->parcelles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getSurfaceTotal(): ?float
    {
        return $this->surfaceTotal;
    }

    public function setSurfaceTotal(?float $surfaceTotal): self
    {
        $this->surfaceTotal = $surfaceTotal;

        return $this;
    }

    public function getSurfaceRecolte(): ?float
    {
        return $this->surfaceRecolte;
    }

    public function setSurfaceRecolte(?float $surfaceRecolte): self
    {
        $this->surfaceRecolte = $surfaceRecolte;

        return $this;
    }

    public function getQuantiteRecolte(): ?float
    {
        return $this->quantiteRecolte;
    }

    public function setQuantiteRecolte(?float $quantiteRecolte): self
    {
        $this->quantiteRecolte = $quantiteRecolte;

        return $this;
    }

    /**
     * @return Collection<int, Recolte>
     */
    public function getParcelles(): Collection
    {
        return $this->parcelles;
    }

    public function addParcelle(Recolte $parcelle): self
    {
        if (!$this->parcelles->contains($parcelle)) {
            $this->parcelles[] = $parcelle;
            $parcelle->setCampagneRecolte($this);
        }

        return $this;
    }

    public function removeParcelle(Recolte $parcelle): self
    {
        if ($this->parcelles->removeElement($parcelle)) {
            // set the owning side to null (unless already changed)
            if ($parcelle->getCampagneRecolte() === $this) {
                $parcelle->setCampagneRecolte(null);
            }
        }

        return $this;
    }
}
