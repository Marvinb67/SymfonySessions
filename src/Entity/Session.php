<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $intitule;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $places_theoriques;

    /**
     * @ORM\Column(type="integer")
     */
    private $placesReserves;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Stagiaire::class, inversedBy="sessions")
     */
    private $stagiaires;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=Planifier::class, mappedBy="sessions")
     */
    private $planifiers;

    public function __construct()
    {
        $this->stagiaires = new ArrayCollection();
        $this->planifiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getPlacesTheoriques(): ?int
    {
        return $this->places_theoriques;
    }

    public function setPlacesTheoriques(int $places_theoriques): self
    {
        $this->places_theoriques = $places_theoriques;

        return $this;
    }

    public function getPlacesReserves(): ?int
    {
        return $this->placesReserves;
    }

    public function setPlacesReserves(int $placesReserves): self
    {
        $this->placesReserves = $placesReserves;

        return $this;
    }

    public function getFormateurs(): ?Formateur
    {
        return $this->formateurs;
    }

    public function setFormateurs(?Formateur $formateurs): self
    {
        $this->formateurs = $formateurs;

        return $this;
    }

    /**
     * @return Collection<int, Stagiaire>
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): self
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires[] = $stagiaire;
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        $this->stagiaires->removeElement($stagiaire);

        return $this;
    }

    public function getFormations(): ?Formation
    {
        return $this->formations;
    }

    public function setFormations(?Formation $formations): self
    {
        $this->formations = $formations;

        return $this;
    }

    /**
     * @return Collection<int, Planifier>
     */
    public function getPlanifiers(): Collection
    {
        return $this->planifiers;
    }

    public function addPlanifier(Planifier $planifier): self
    {
        if (!$this->planifiers->contains($planifier)) {
            $this->planifiers[] = $planifier;
            $planifier->setSessions($this);
        }

        return $this;
    }

    public function removePlanifier(Planifier $planifier): self
    {
        if ($this->planifiers->removeElement($planifier)) {
            // set the owning side to null (unless already changed)
            if ($planifier->getSessions() === $this) {
                $planifier->setSessions(null);
            }
        }

        return $this;
    }

    public function getPlacesR()
    {
        $nbstagiaire = count($this->getstagiaires());

        return $nbstagiaire;
    }

    public function placesRestantes()
    {
        $placeT = $this->getPlacesTheoriques();
        $placeR = $this->getPlacesR();

        $placesRestante = $placeT - $placeR;

        if ($placesRestante == 0) {
            $message = 'Session complete';
        } else {
            $message = $placesRestante;
        }

        return $message;
    }

    public function __toString()
    {
        return $this->intitule;
    }
}
