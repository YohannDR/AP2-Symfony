<?php

namespace App\Entity;

use App\Repository\IdentiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IdentiteRepository::class)
 */
class Identite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $responsablePublication;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $concepteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $animation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hebergeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getProprietaire(): ?string
    {
        return $this->proprietaire;
    }

    public function setProprietaire(string $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getResponsablePublication(): ?string
    {
        return $this->responsablePublication;
    }

    public function setResponsablePublication(string $responsablePublication): self
    {
        $this->responsablePublication = $responsablePublication;

        return $this;
    }

    public function getConcepteur(): ?string
    {
        return $this->concepteur;
    }

    public function setConcepteur(string $concepteur): self
    {
        $this->concepteur = $concepteur;

        return $this;
    }

    public function getAnimation(): ?string
    {
        return $this->animation;
    }

    public function setAnimation(string $animation): self
    {
        $this->animation = $animation;

        return $this;
    }

    public function getHebergeur(): ?string
    {
        return $this->hebergeur;
    }

    public function setHebergeur(string $hebergeur): self
    {
        $this->hebergeur = $hebergeur;

        return $this;
    }
}
