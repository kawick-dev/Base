<?php

namespace App\Entity;

use App\Repository\PoidsRemorqueRecolteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PoidsRemorqueRecolteRepository::class)]
class PoidsRemorqueRecolte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $Poids;

    #[ORM\Column(type: 'float')]
    private $matiereSeche;

    #[ORM\ManyToOne(targetEntity: Recolte::class, inversedBy: 'remorques')]
    private $recolte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoids(): ?float
    {
        return $this->Poids;
    }

    public function setPoids(float $Poids): self
    {
        $this->Poids = $Poids;

        return $this;
    }

    public function getMatiereSeche(): ?float
    {
        return $this->matiereSeche;
    }

    public function setMatiereSeche(float $matiereSeche): self
    {
        $this->matiereSeche = $matiereSeche;

        return $this;
    }

    public function getRecolte(): ?Recolte
    {
        return $this->recolte;
    }

    public function setRecolte(?Recolte $recolte): self
    {
        $this->recolte = $recolte;

        return $this;
    }
}
