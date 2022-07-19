<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $slug;

    #[ORM\Column(type: 'datetime_immutable')]
    private $startedAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $contactEmail;

    #[ORM\ManyToMany(targetEntity: Topic::class, mappedBy: 'Quizzes')]
    private $Topics;

    #[ORM\ManyToOne(targetEntity: EventSession::class, inversedBy: 'Quizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private $EventSession;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $step;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $points;

    #[ORM\ManyToMany(targetEntity: Question::class)]
    private $Questions;

    #[ORM\Column(type: 'datetime')]
    private $lastStart;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $famename = null;


    public function __construct()
    {
        $this->Topics = new ArrayCollection();
        $this->EventSessions = new ArrayCollection();
        $this->Questions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->slug;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): self
    {
        $this->contactEmail = $contactEmail;

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
            $Topic->addQuiz($this);
        }

        return $this;
    }

    public function removeTopic(Topic $Topic): self
    {
        if ($this->Topics->removeElement($Topic)) {
            $Topic->removeQuiz($this);
        }

        return $this;
    }

    public function getEventSession(): ?EventSession
    {
        return $this->EventSession;
    }

    public function setEventSession(?EventSession $EventSession): self
    {
        $this->EventSession = $EventSession;

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(?int $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    #[ORM\PrePersist]
    public function setActiveValue(): void
    {
        $this->step = 1;
        $this->points = 0;
        $this->lastStart = new \DateTime();
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->Questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->Questions->contains($question)) {
            $this->Questions[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        $this->Questions->removeElement($question);

        return $this;
    }

    public function getLastStart(): ?\DateTimeInterface
    {
        return $this->lastStart;
    }

    public function setLastStart(\DateTimeInterface $lastStart): self
    {
        $this->lastStart = $lastStart;

        return $this;
    }

    public function getFamename(): ?string
    {
        return $this->famename;
    }

    public function setFamename(?string $famename): self
    {
        $this->famename = $famename;

        return $this;
    }

}
