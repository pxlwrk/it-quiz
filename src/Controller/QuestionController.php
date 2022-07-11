<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/question')]
class QuestionController extends AbstractController
{
    #[Route('/', name: 'app_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository): Response
    {
        return $this->render('question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionRepository $questionRepository): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->add($question, true);
            $this->addFlash(
                'success',
                'Ich habe eine neue Frage für dich angelegt!'
            );
            return $this->redirectToRoute('app_question_show', ['id' => $question->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        $answer = new Answer();
        $answer->setQuestion($question);
        $form = $this->createForm(AnswerType::class, $answer, [
            'action' => $this->generateUrl('app_question_answer', ['id' => $question->getId()]),
            'method' => 'POST'
        ]);
        return $this->render('question/show.html.twig', [
            'question' => $question,
            'answer' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->add($question, true);
            $this->addFlash(
                'success',
                'Deine Änderungen habe ich für dich gespeichert!'
            );
            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
        }
        $this->addFlash(
            'warning',
            'Ich habe die Frage für dich gelöscht und alle zugehörigen Antworten auch!'
        );
        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/answer', name: 'app_question_answer', methods: ['POST'])]
    public function answer(Request $request, Question $question, AnswerRepository $answerRepository): Response
    {
        $answer = new Answer();
        $answer->setQuestion($question);
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answerRepository->add($answer, true);

            $this->addFlash(
                'success',
                'Ich habe die neue Antwort gespeichert!'
            );
            return $this->redirectToRoute('app_question_show', ['id' => $answer->getQuestion()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/answer/delete', name: 'app_question_answer_delete', methods: ['GET'])]
    public function answer_delete(Request $request, Answer $answer, AnswerRepository $answerRepository): Response
    {
        $questionid = $answer->getQuestion()->getId();
        $answerRepository->remove($answer, true);
        $this->addFlash(
            'warning',
            'Die Antwort habe ich für dich gelöscht!'
        );
        return $this->redirectToRoute('app_question_show', ['id' => $questionid], Response::HTTP_SEE_OTHER);

    }

}
