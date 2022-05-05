<?php

namespace App\Entity;

use App\Repository\ParcelleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcelleRepository::class)]
class Parcelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $commune;

    #[ORM\Column(type: 'float')]
    private $superficie;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $coordonnegps;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\Column(type: 'string', length: 255)]
    private $codenum;

    #[ORM\Column(type: 'boolean')]
    private $exploiter;

    #[ORM\ManyToOne(targetEntity: Exploitant::class, inversedBy: 'parcelles')]
    private $proprietaire;

    #[ORM\OneToMany(mappedBy: 'parcelle', targetEntity: Epandage::class)]
    private $epandages;

    #[ORM\OneToMany(mappedBy: 'parcelle', targetEntity: Recolte::class)]
    private $recoltes;

    public function __construct()
    {
        $this->epandages = new ArrayCollection();
        $this->recoltes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCoordonnegps(): ?string
    {
        return $this->coordonnegps;
    }

    public function setCoordonnegps(string $coordonnegps): self
    {
        $this->coordonnegps = $coordonnegps;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCodenum(): ?string
    {
        return $this->codenum;
    }

    public function setCodenum(string $codenum): self
    {
        $this->codenum = $codenum;

        return $this;
    }

    public function getExploiter(): ?bool
    {
        return $this->exploiter;
    }

    public function setExploiter(bool $exploiter): self
    {
        $this->exploiter = $exploiter;

        return $this;
    }

    public function getProprietaire(): ?Exploitant
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Exploitant $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

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
            $epandage->setParcelle($this);
        }

        return $this;
    }

    public function removeEpandage(Epandage $epandage): self
    {
        if ($this->epandages->removeElement($epandage)) {
            // set the owning side to null (unless already changed)
            if ($epandage->getParcelle() === $this) {
                $epandage->setParcelle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recolte>
     */
    public function getRecoltes(): Collection
    {
        return $this->recoltes;
    }

    public function addRecolte(Recolte $recolte): self
    {
        if (!$this->recoltes->contains($recolte)) {
            $this->recoltes[] = $recolte;
            $recolte->setParcelle($this);
        }

        return $this;
    }

    public function removeRecolte(Recolte $recolte): self
    {
        if ($this->recoltes->removeElement($recolte)) {
            // set the owning side to null (unless already changed)
            if ($recolte->getParcelle() === $this) {
                $recolte->setParcelle(null);
            }
        }

        return $this;
    }
}
