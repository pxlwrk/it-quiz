<?php

namespace App\Controller;

use App\Entity\Quiz;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;

class QuizController extends AbstractController
{
    #[Route('/quiz/new', name: 'app_quiz')]
    public function start(ManagerRegistry $doctrine): Response
    {
        $slug = ByteString::fromRandom(10)->toString();

        $quiz = new Quiz();
        $quiz->setSlug($slug)
            ->setStartedAt(new \DateTimeImmutable());
        $em = $doctrine->getManager();
        $em->persist($quiz);
        $em->flush();

        return $this->redirectToRoute('quiz_play', ['slug' => $slug]);
    }

    #[Route('/quiz/{slug}', name: 'quiz_play')]
    public function play(ManagerRegistry $doctrine, string $slug): Response
    {
        return $this->render('/quiz/index.html.twig', [
            'slug' => $slug
        ]);
    }
}
