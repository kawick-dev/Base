<?php

namespace App\Entity;

use App\Repository\RecolteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecolteRepository::class)]
class Recolte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $culture;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\Column(type: 'integer')]
    private $effectuer;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_recolte;

    #[ORM\ManyToOne(targetEntity: CampagneRecolte::class, inversedBy: 'parcelles')]
    private $campagneRecolte;

    #[ORM\ManyToOne(targetEntity: Parcelle::class, inversedBy: 'recoltes')]
    private $parcelle;

    #[ORM\OneToMany(mappedBy: 'recolte', targetEntity: PoidsRemorqueRecolte::class)]
    private $remorques;

    #[ORM\Column(type: 'float', nullable: true)]
    private $PoidsTotal;

    #[ORM\Column(type: 'float', nullable: true)]
    private $MatiereSecheMoy;

    public function __construct()
    {
        $this->remorques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCulture(): ?string
    {
        return $this->culture;
    }

    public function setCulture(?string $culture): self
    {
        $this->culture = $culture;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getEffectuer(): ?int
    {
        return $this->effectuer;
    }

    public function setEffectuer(int $effectuer): self
    {
        $this->effectuer = $effectuer;

        return $this;
    }

    public function getDateRecolte(): ?\DateTimeInterface
    {
        return $this->date_recolte;
    }

    public function setDateRecolte(\DateTimeInterface $date_recolte): self
    {
        $this->date_recolte = $date_recolte;

        return $this;
    }

    public function getCampagneRecolte(): ?CampagneRecolte
    {
        return $this->campagneRecolte;
    }

    public function setCampagneRecolte(?CampagneRecolte $campagneRecolte): self
    {
        $this->campagneRecolte = $campagneRecolte;

        return $this;
    }

    public function getParcelle(): ?Parcelle
    {
        return $this->parcelle;
    }

    public function setParcelle(?Parcelle $parcelle): self
    {
        $this->parcelle = $parcelle;

        return $this;
    }

    /**
     * @return Collection<int, PoidsRemorqueRecolte>
     */
    public function getRemorques(): Collection
    {
        return $this->remorques;
    }

    public function addRemorque(PoidsRemorqueRecolte $remorque): self
    {
        if (!$this->remorques->contains($remorque)) {
            $this->remorques[] = $remorque;
            $remorque->setRecolte($this);
        }

        return $this;
    }

    public function removeRemorque(PoidsRemorqueRecolte $remorque): self
    {
        if ($this->remorques->removeElement($remorque)) {
            // set the owning side to null (unless already changed)
            if ($remorque->getRecolte() === $this) {
                $remorque->setRecolte(null);
            }
        }

        return $this;
    }

    public function getPoidsTotal(): ?float
    {
        return $this->PoidsTotal;
    }

    public function setPoidsTotal(?float $PoidsTotal): self
    {
        $this->PoidsTotal = $PoidsTotal;

        return $this;
    }

    public function getMatiereSecheMoy(): ?float
    {
        return $this->MatiereSecheMoy;
    }

    public function setMatiereSecheMoy(?float $MatiereSecheMoy): self
    {
        $this->MatiereSecheMoy = $MatiereSecheMoy;

        return $this;
    }
}
