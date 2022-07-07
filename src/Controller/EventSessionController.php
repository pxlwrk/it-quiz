<?php

namespace App\Controller;

use App\Entity\EventSession;
use App\Form\EventSessionType;
use App\Repository\EventSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/event/session')]
class EventSessionController extends AbstractController
{
    #[Route('/', name: 'app_event_session_index', methods: ['GET'])]
    public function index(EventSessionRepository $eventSessionRepository): Response
    {
        return $this->render('event_session/index.html.twig', [
            'event_sessions' => $eventSessionRepository->findAll(),
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

        return $this->redirectToRoute('app_event_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
