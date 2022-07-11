<?php

namespace App\Controller;

use App\Entity\EventSession;
use App\Form\EventSessionType;
use App\Repository\EventSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/event')]
class EventSessionController extends AbstractController
{
    #[Route('/', name: 'app_event_session_index', methods: ['GET'])]
    public function index(EventSessionRepository $eventSessionRepository): Response
    {
        return $this->render('event_session/index.html.twig', [
            'event_sessions' => $eventSessionRepository->findBy([], ['eventDate' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_event_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EventSessionRepository $eventSessionRepository): Response
    {
        $eventSession = new EventSession();
        $form = $this->createForm(EventSessionType::class, $eventSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventSessionRepository->add($eventSession, true);
            $this->addFlash(
                'success',
                'Ich habe eine neue Veranstaltung für dich angelegt!'
            );
            return $this->redirectToRoute('app_event_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_session/new.html.twig', [
            'event_session' => $eventSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_session_show', methods: ['GET'])]
    public function show(EventSession $eventSession): Response
    {
        return $this->render('event_session/show.html.twig', [
            'event_session' => $eventSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventSession $eventSession, EventSessionRepository $eventSessionRepository): Response
    {
        $form = $this->createForm(EventSessionType::class, $eventSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventSessionRepository->add($eventSession, true);
            $this->addFlash(
                'success',
                'Deine Änderungen habe ich für dich gespeichert!'
            );
            return $this->redirectToRoute('app_event_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_session/edit.html.twig', [
            'event_session' => $eventSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_session_delete', methods: ['POST'])]
    public function delete(Request $request, EventSession $eventSession, EventSessionRepository $eventSessionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventSession->getId(), $request->request->get('_token'))) {
            $eventSessionRepository->remove($eventSession, true);
        }
        $this->addFlash(
            'warning',
            'Ich habe die Veranstaltung für dich gelöscht und alle zugehörigen Quizze auch!'
        );
        return $this->redirectToRoute('app_event_session_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/active', name: 'app_event_session_active', methods: ['GET'])]
    public function setActive(EventSession $eventSession, EventSessionRepository $eventSessionRepository): Response
    {
        $eventSession->setIsActive(!$eventSession->isIsActive());
        $eventSessionRepository->add($eventSession, true);
        $this->addFlash(
            'success',
            'Ich habe die Sichtbarkeit der Veranstaltung für dich angepasst.'
        );
        return $this->redirectToRoute('app_event_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
