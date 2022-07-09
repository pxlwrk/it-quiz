<?php

namespace App\Entity;

use App\Repository\EventSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventSessionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class EventSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'boolean')]
    private $isActive;

    #[ORM\ManyToMany(targetEntity: Topic::class, inversedBy: 'EventSessions')]
    private $Topics;

    #[ORM\OneToMany(mappedBy: 'EventSession', targetEntity: Quiz::class, orphanRemoval: true)]
    private $Quizzes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $decription;

    #[ORM\Column(type: 'datetime')]
    private $eventDate;


    public function __construct()
    {
        $this->Topics = new ArrayCollection();
        $this->Quizzes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->Topics;
    }

    public function addTopic(Topic $Topic): self
    {
        if (!$this->Topics->contains($Topic)) {
            $this->Topics[] = $Topic;
        }

        return $this;
    }

    public function removeTopic(Topic $Topic): self
    {
        $this->Topics->removeElement($Topic);

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->Quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->Quizzes->contains($quiz)) {
            $this->Quizzes[] = $quiz;
            $quiz->setEventSession($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->Quizzes->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getEventSession() === $this) {
                $quiz->setEventSession(null);
            }
        }

        return $this;
    }

    public function getDecription(): ?string
    {
        return $this->decription;
    }

    public function setDecription(?string $decription): self
    {
        $this->decription = $decription;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    #[ORM\PrePersist]
    public function setActiveValue(): void
    {
        $this->isActive = false;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
