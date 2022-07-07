<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToMany(targetEntity: Quiz::class, inversedBy: 'Topics')]
    private $Quizzes;

    #[ORM\OneToMany(mappedBy: 'Topic', targetEntity: Question::class)]
    private $Questions;

    #[ORM\ManyToMany(targetEntity: EventSession::class, mappedBy: 'Topics')]
    private $EventSessions;

    public function __construct()
    {
        $this->Quizzes = new ArrayCollection();
        $this->Questions = new ArrayCollection();
        $this->EventSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->Quizzes;
    }

    public function addQuiz(Quiz $Quiz): self
    {
        if (!$this->Quizzes->contains($Quiz)) {
            $this->Quizzes[] = $Quiz;
        }

        return $this;
    }

    public function removeQuiz(Quiz $Quiz): self
    {
        $this->Quizzes->removeElement($Quiz);

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->Questions;
    }

    public function addQuestion(Question $Question): self
    {
        if (!$this->Questions->contains($Question)) {
            $this->Questions[] = $Question;
            $Question->setTopic($this);
        }

        return $this;
    }

    public function removeQuestion(Question $Question): self
    {
        if ($this->Questions->removeElement($Question)) {
            // set the owning side to null (unless already changed)
            if ($Question->getTopic() === $this) {
                $Question->setTopic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EventSession>
     */
    public function getEventSessions(): Collection
    {
        return $this->EventSessions;
    }

    public function addEventSession(EventSession $EventSession): self
    {
        if (!$this->EventSessions->contains($EventSession)) {
            $this->EventSessions[] = $EventSession;
            $EventSession->addTopic($this);
        }

        return $this;
    }

    public function removeEventSession(EventSession $EventSession): self
    {
        if ($this->EventSessions->removeElement($EventSession)) {
            $EventSession->removeTopic($this);
        }

        return $this;
    }
}
