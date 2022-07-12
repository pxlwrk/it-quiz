<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\EventSession;
use App\Entity\Question;
use App\Entity\Quiz;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;


class QuizController extends AbstractController
{
    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/quiz/new/{id}', name: 'app_quiz')]
    public function start(ManagerRegistry $doctrine, EventSession $eventSession): Response
    {
        if (!$eventSession) {
            throw $this->createNotFoundException(
                'EventSession nicht gefunden! // Line: '.__LINE__
            );
        }
        $slug = ByteString::fromRandom(10)->toString();
        $quiz = new Quiz();
        foreach ($eventSession->getTopics() as $topic)
            $quiz->addTopic($topic);
        $quiz->setSlug($slug)
            ->setEventSession($eventSession)
            ->setStartedAt(new \DateTimeImmutable())
            ->setLastStart(new \DateTime())
        ;
        $em = $doctrine->getManager();
        $em->persist($quiz);
        $em->flush();

        return $this->redirectToRoute('quiz_play', ['slug' => $slug]);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param string $slug
     * @return Response
     */
    #[Route('/quiz/{slug}', name: 'quiz_play')]
    public function play(ManagerRegistry $doctrine, Quiz $quiz): Response
    {
        if (!$quiz) {
            throw $this->createNotFoundException(
                'Quiz nicht gefunden!'
            );
        }

        if ($quiz->getStep() > 10)
            return $this->redirectToRoute('app_quiz_result', ['slug' => $quiz->getSlug()]);

        if ($quiz->getStep() <=3 ) $difficulty = 1;
        elseif ($quiz->getStep() <= 6 ) $difficulty = 2;
        else $difficulty = 3;

        $em = $doctrine->getManager();
        $question = $em->getRepository(Question::class)->findRandom($quiz, $difficulty);

        if (!$question)
            return $this->redirectToRoute('app_quiz_result', ['slug' => $quiz->getSlug()]);

        $quiz->setLastStart(new \DateTime());
        $em->getRepository(Quiz::class)->add($quiz, true);



        return $this->render('/quiz/play.html.twig', [
            'quiz' => $quiz,
            'question' => $question
        ]);
    }

    #[Route('/quiz/{slug}/vote/{question}/{answer}', name: 'quiz_vote')]
    public function vote(ManagerRegistry $doctrine, Quiz $quiz, Question $question, Answer $answer)
    {
        if (!$quiz->getQuestions()->contains($question)) {
            $usedTime = $quiz->getLastStart()->diff(new \DateTime())->s;

            if ($usedTime <= 5) $timeFactor = 50;
            elseif ($usedTime <= 7) $timeFactor = 30;
            elseif ($usedTime <= 10) $timeFactor = 15;
            elseif ($usedTime <= 15) $timeFactor = 10;
            elseif ($usedTime <= 20) $timeFactor = 5;
            elseif ($usedTime <= 30) $timeFactor = 3;
            else $timeFactor = 1;

            if ($answer->isCorrect()) {
                $quiz->setPoints($quiz->getPoints() + ($question->getDifficulty() * 10 * $timeFactor));
            }

            $quiz->addQuestion($question)
                ->setStep($quiz->getStep() + 1)
            ;
            $doctrine->getRepository(Quiz::class)->add($quiz, true);
        }

        return $this->render('/quiz/vote.html.twig', [
            'quiz' => $quiz,
            'question' => $question,
            'answer' => $answer,
            'tf' => $timeFactor,
            'used' => $usedTime
        ]);
    }

    #[Route('/quiz/{slug}/result', name: 'app_quiz_result')]
    public function results(ManagerRegistry $doctrine, Quiz $quiz)
    {
        $quizzes = $doctrine->getRepository(Quiz::class)->hallOfFame($quiz->getEventSession());
        return $this->render('/quiz/result.html.twig', [
            'quiz' => $quiz,
            'quizzes' => $quizzes
        ]);
    }
}
