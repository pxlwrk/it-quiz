<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'integer')]
    private $difficulty;

    #[ORM\ManyToOne(targetEntity: Topic::class, inversedBy: 'Questions')]
    #[ORM\JoinColumn(nullable: false)]
    private $Topic;

    #[ORM\OneToMany(mappedBy: 'Question', targetEntity: Answer::class, orphanRemoval: true)]
    private $Answers;

    public function __construct()
    {
        $this->Answers = new ArrayCollection();
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

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->Topic;
    }

    public function setTopic(?Topic $Topic): self
    {
        $this->Topic = $Topic;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->Answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->Answers->contains($answer)) {
            $this->Answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->Answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
