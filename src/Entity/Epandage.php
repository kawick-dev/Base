<?php

namespace App\Entity;

use App\Repository\EpandageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpandageRepository::class)]
class Epandage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Campagne::class, inversedBy: 'epandages')]
    private $campagne;

    #[ORM\ManyToOne(targetEntity: Parcelle::class, inversedBy: 'epandages')]
    private $parcelle;

    #[ORM\Column(type: 'float')]
    private $quantite;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $effectuer;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_epandage;

    #[ORM\Column(type: 'string', length: 255)]
    private $culture;

    #[ORM\Column(type: 'float')]
    private $surfaceEpandue;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $camion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->campagne;
    }

    public function setCampagne(?Campagne $campagne): self
    {
        $this->campagne = $campagne;

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

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateEpandage(): ?\DateTimeInterface
    {
        return $this->date_epandage;
    }

    public function setDateEpandage(?\DateTimeInterface $date_epandage): self
    {
        $this->date_epandage = $date_epandage;

        return $this;
    }

    public function getCulture(): ?string
    {
        return $this->culture;
    }

    public function setCulture(string $culture): self
    {
        $this->culture = $culture;

        return $this;
    }

    public function getSurfaceEpandue(): ?float
    {
        return $this->surfaceEpandue;
    }

    public function setSurfaceEpandue(float $surfaceEpandue): self
    {
        $this->surfaceEpandue = $surfaceEpandue;

        return $this;
    }

    public function getCamion(): ?int
    {
        return $this->camion;
    }

    public function setCamion(?int $camion): self
    {
        $this->camion = $camion;

        return $this;
    }

}
