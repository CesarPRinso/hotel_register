<?php

namespace App\Controller;

use App\Service\HotelService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    private $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    #[Route('/hotels', name: 'hotel_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $hotels = $this->hotelService->getAllHotels();
        return $this->json($hotels);
    }

    #[Route('/hotels/{id}', name: 'hotel_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $hotel = $this->hotelService->getHotel($id);
        return $this->json($hotel);
    }

    #[Route('/hotels', name: 'hotel_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $hotel = $this->hotelService->createHotel($data);
        return $this->json($hotel, JsonResponse::HTTP_CREATED);
    }

    #[Route('/hotels/{id}', name: 'hotel_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $hotel = $this->hotelService->updateHotel($id, $data);
        return $this->json($hotel);
    }

    #[Route('/hotels/{id}', name: 'hotel_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->hotelService->deleteHotel($id);
        return $this->json(['status' => 'Hotel deleted'], JsonResponse::HTTP_NO_CONTENT);
    }
}
