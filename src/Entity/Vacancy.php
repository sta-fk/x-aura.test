<?php

namespace App\Entity;

use App\Repository\VacancyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VacancyRepository::class)]
class Vacancy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'vacancies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\OneToMany(targetEntity: VacancyResume::class, mappedBy: 'vacancy')]
    private Collection $resumes;

    public function __construct()
    {
        $this->resumes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name . ' in ' . $this->getCompanyName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function getCompanyName(): ?string
    {
        return $this->company?->getName();
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, VacancyResume>
     */
    public function getResumes(): Collection
    {
        return $this->resumes;
    }

    public function addResume(VacancyResume $resume): static
    {
        if (!$this->resumes->contains($resume)) {
            $this->resumes->add($resume);
            $resume->setVacancy($this);
        }

        return $this;
    }

    public function removeResume(VacancyResume $resume): static
    {
        if ($this->resumes->removeElement($resume)) {
            // set the owning side to null (unless already changed)
            if ($resume->getVacancy() === $this) {
                $resume->setVacancy(null);
            }
        }

        return $this;
    }
}
