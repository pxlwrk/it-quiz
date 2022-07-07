<?php

namespace App\Controller;

use App\Entity\EventSession;
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
        $quiz->setSlug($slug)
            ->setEventSession($eventSession)
            ->setStartedAt(new \DateTimeImmutable());
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
        $em = $doctrine->getManager();

        return $this->render('/quiz/play.html.twig', [
            'quiz' => $quiz
        ]);
    }
}
