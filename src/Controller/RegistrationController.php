<?php

namespace App\Controller;

use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    #[Route('/registrations', name: 'registration_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $registrations = $this->registrationService->getAllRegistrations();
        return $this->json($registrations);
    }

    #[Route('/registrations/{id}', name: 'registration_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $registration = $this->registrationService->getRegistration($id);
        return $this->json($registration);
    }

    #[Route('/registrations', name: 'registration_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $registration = $this->registrationService->createRegistration($data);
        return $this->json($registration, JsonResponse::HTTP_CREATED);
    }

    #[Route('/registrations/{id}', name: 'registration_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $registration = $this->registrationService->updateRegistration($id, $data);
        return $this->json($registration);
    }

    #[Route('/registrations/{id}', name: 'registration_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->registrationService->deleteRegistration($id);
        return $this->json(['status' => 'Registration deleted'], JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/registrations/hotel/{hotelId}', name: 'registration_by_hotel', methods: ['GET'])]
    public function getByHotel(int $hotelId): JsonResponse
    {
        $registrations = $this->registrationService->getRegistrationsByHotel($hotelId);
        return $this->json($registrations);
    }

    #[Route('/registrations/status/hotel/{hotelId}', name: 'registration_status_by_hotel', methods: ['GET'])]
    public function getStatusByHotel(int $hotelId): JsonResponse
    {
        $statuses = $this->registrationService->getRegistrationStatusesByHotel($hotelId);
        return $this->json($statuses);
    }

    #[Route('/registrations/hotel/{hotelId}/date-range', name: 'registration_by_hotel_date_range', methods: ['GET'])]
    public function getUsersByHotelAndDateRange(int $hotelId, Request $request): JsonResponse
    {
        $startDate = $request->query->get('start_date');
        $endDate = $request->query->get('end_date');
        $users = $this->registrationService->getUsersByHotelAndDateRange($hotelId, $startDate, $endDate);
        return $this->json($users);
    }
}
