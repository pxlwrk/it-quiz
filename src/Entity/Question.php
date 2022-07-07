<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
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

    #[ORM\Column(type: 'string', length: 255)]
    private $answerA;

    #[ORM\Column(type: 'string', length: 255)]
    private $answerB;

    #[ORM\Column(type: 'string', length: 255)]
    private $answerC;

    #[ORM\ManyToOne(targetEntity: Topic::class, inversedBy: 'Questions')]
    #[ORM\JoinColumn(nullable: false)]
    private $Topic;

    #[ORM\Column(type: 'boolean')]
    private $solutionA;

    #[ORM\Column(type: 'boolean')]
    private $solutionB;

    #[ORM\Column(type: 'boolean')]
    private $solutionC;

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

    public function getAnswerA(): ?string
    {
        return $this->answerA;
    }

    public function setAnswerA(string $answerA): self
    {
        $this->answerA = $answerA;

        return $this;
    }

    public function getAnswerB(): ?string
    {
        return $this->answerB;
    }

    public function setAnswerB(string $answerB): self
    {
        $this->answerB = $answerB;

        return $this;
    }

    public function getAnswerC(): ?string
    {
        return $this->answerC;
    }

    public function setAnswerC(string $answerC): self
    {
        $this->answerC = $answerC;

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

    public function isSolutionA(): ?bool
    {
        return $this->solutionA;
    }

    public function setSolutionA(bool $solutionA): self
    {
        $this->solutionA = $solutionA;

        return $this;
    }

    public function isSolutionB(): ?bool
    {
        return $this->solutionB;
    }

    public function setSolutionB(bool $solutionB): self
    {
        $this->solutionB = $solutionB;

        return $this;
    }

    public function isSolutionC(): ?bool
    {
        return $this->solutionC;
    }

    public function setSolutionC(bool $solutionC): self
    {
        $this->solutionC = $solutionC;

        return $this;
    }
}
