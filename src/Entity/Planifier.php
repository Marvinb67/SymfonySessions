<?php

namespace App\Entity;

use App\Repository\PlanifierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanifierRepository::class)
 */
class Planifier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="planifiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sessions;

    /**
     * @ORM\ManyToOne(targetEntity=ModuleFormation::class, inversedBy="planifiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modulesFormation;

    /**
     * @ORM\Column(type="float")
     */
    private $duree;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessions(): ?Session
    {
        return $this->sessions;
    }

    public function setSessions(?Session $sessions): self
    {
        $this->sessions = $sessions;

        return $this;
    }

    public function getModulesFormation(): ?ModuleFormation
    {
        return $this->modulesFormation;
    }

    public function setModulesFormation(?ModuleFormation $modulesFormation): self
    {
        $this->modulesFormation = $modulesFormation;

        return $this;
    }

    public function getDuree(): ?float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): self
    {
        $this->duree = $duree;

        return $this;
    }
}
