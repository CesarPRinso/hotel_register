<?php

namespace App\Controller;

use App\Service\GuestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GuestController extends AbstractController
{
    private $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    #[Route('/guests', name: 'guest_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $guests = $this->guestService->getAllGuests();
        return $this->json($guests);
    }

    #[Route('/guests/{id}', name: 'guest_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $guest = $this->guestService->getGuest($id);
        return $this->json($guest);
    }

    #[Route('/guests', name: 'guest_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $guest = $this->guestService->createGuest($data);
        return $this->json($guest, JsonResponse::HTTP_CREATED);
    }

    #[Route('/guests/{id}', name: 'guest_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $guest = $this->guestService->updateGuest($id, $data);
        return $this->json($guest);
    }

    #[Route('/guests/{id}', name: 'guest_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->guestService->deleteGuest($id);
        return $this->json(['status' => 'Guest deleted'], JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/guests/{guestId}/registrations', name: 'registrations_by_guest', methods: ['GET'])]
    public function getRegistrationsByGuest(int $guestId): JsonResponse
    {
        $registrations = $this->guestService->getRegistrationsByGuest($guestId);
        return $this->json($registrations);
    }

    #[Route('/guests/{guestId}/statuses', name: 'registration_status_by_guest', methods: ['GET'])]
    public function getRegistrationStatusesByGuest(int $guestId): JsonResponse
    {
        $statuses = $this->guestService->getRegistrationStatusesByGuest($guestId);
        return $this->json($statuses);
    }
}
