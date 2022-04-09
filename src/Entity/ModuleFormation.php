<?php

namespace App\Entity;

use App\Repository\ModuleFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModuleFormationRepository::class)
 */
class ModuleFormation
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
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="moduleFormations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Planifier::class, mappedBy="modulesFormation")
     */
    private $planifiers;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
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

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): self
    {
        $this->categories = $categories;

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
            $planifier->setModulesFormation($this);
        }

        return $this;
    }

    public function removePlanifier(Planifier $planifier): self
    {
        if ($this->planifiers->removeElement($planifier)) {
            // set the owning side to null (unless already changed)
            if ($planifier->getModulesFormation() === $this) {
                $planifier->setModulesFormation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->intitule;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
