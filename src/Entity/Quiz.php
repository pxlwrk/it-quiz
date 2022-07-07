<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
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


    public function __construct()
    {
        $this->Topics = new ArrayCollection();
        $this->EventSessions = new ArrayCollection();
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


}
