<?php

namespace App\Entity;

use App\Repository\CampagneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
class Campagne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'date')]
    private $date_debut;

    #[ORM\Column(type: 'date')]
    private $date_fin;

    #[ORM\OneToMany(mappedBy: 'campagne', targetEntity: Epandage::class)]
    private $epandages;

    #[ORM\Column(type: 'float', nullable: true)]
    private $SurfaceTotal;

    #[ORM\Column(type: 'float', nullable: true)]
    private $QuantiteTotal;

    #[ORM\Column(type: 'float', nullable: true)]
    private $SurfaceEpandueTotal;

    #[ORM\Column(type: 'float', nullable: true)]
    private $SurfaceRealise;

    public function __construct()
    {
        $this->epandages = new ArrayCollection();
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
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    /**
     * @return Collection|Epandage[]
     */
    public function getEpandages(): Collection
    {
        return $this->epandages;
    }

    public function addEpandage(Epandage $epandage): self
    {
        if (!$this->epandages->contains($epandage)) {
            $this->epandages[] = $epandage;
            $epandage->setCampagne($this);
        }

        return $this;
    }

    public function removeEpandage(Epandage $epandage): self
    {
        if ($this->epandages->removeElement($epandage)) {
            // set the owning side to null (unless already changed)
            if ($epandage->getCampagne() === $this) {
                $epandage->setCampagne(null);
            }
        }

        return $this;
    }

    public function getSurfaceTotal(): ?float
    {
        return $this->SurfaceTotal;
    }

    public function setSurfaceTotal(?float $SurfaceTotal): self
    {
        $this->SurfaceTotal = $SurfaceTotal;

        return $this;
    }

    public function getQuantiteTotal(): ?float
    {
        return $this->QuantiteTotal;
    }

    public function setQuantiteTotal(?float $QuantiteTotal): self
    {
        $this->QuantiteTotal = $QuantiteTotal;

        return $this;
    }

    public function getSurfaceEpandueTotal(): ?float
    {
        return $this->SurfaceEpandueTotal;
    }

    public function setSurfaceEpandueTotal(?float $SurfaceEpandueTotal): self
    {
        $this->SurfaceEpandueTotal = $SurfaceEpandueTotal;

        return $this;
    }

    public function getSurfaceRealise(): ?float
    {
        return $this->SurfaceRealise;
    }

    public function setSurfaceRealise(?float $SurfaceRealise): self
    {
        $this->SurfaceRealise = $SurfaceRealise;

        return $this;
    }
}
