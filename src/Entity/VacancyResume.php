<?php

namespace App\Entity;

use App\Repository\VacancyResumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VacancyResumeRepository::class)]
class VacancyResume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'resumes')]
    private ?Vacancy $vacancy = null;

    #[ORM\Column(type: Types::BLOB)]
    private $content;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: VacancyResumeMark::class, mappedBy: 'resume')]
    private Collection $marks;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
        $this->marks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVacancy(): ?Vacancy
    {
        return $this->vacancy;
    }

    public function setVacancy(?Vacancy $vacancy): static
    {
        $this->vacancy = $vacancy;

        return $this;
    }

    public function getContent()
    {
        return is_resource($this->content) ? stream_get_contents($this->content) : $this->content;
    }

    public function getShortContent(): string
    {
        return stream_get_contents($this->content, 50) . '... ';
    }

    public function setContent($content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function updateDate(): static
    {
        $this->updatedAt = new \DateTimeImmutable('now');

        return $this;
    }

    /**
     * @return Collection<int, VacancyResumeMark>
     */
    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(VacancyResumeMark $mark): static
    {
        if (!$this->marks->contains($mark)) {
            $this->marks->add($mark);
            $mark->setResume($this);
        }

        return $this;
    }

    public function removeMark(VacancyResumeMark $mark): static
    {
        if ($this->marks->removeElement($mark)) {
            // set the owning side to null (unless already changed)
            if ($mark->getResume() === $this) {
                $mark->setResume(null);
            }
        }

        return $this;
    }
}
