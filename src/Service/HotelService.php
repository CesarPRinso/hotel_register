<?php

namespace App\Service;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;

class HotelService
{
    private $entityManager;
    private $hotelRepository;

    public function __construct(EntityManagerInterface $entityManager, HotelRepository $hotelRepository)
    {
        $this->entityManager = $entityManager;
        $this->hotelRepository = $hotelRepository;
    }

    public function createHotel(array $hotelData): Hotel
    {
        $hotel = new Hotel();
        $hotel->setName($hotelData['name']);
        $hotel->setCity($hotelData['city']);
        $hotel->setCountry($hotelData['country']);
        $this->entityManager->persist($hotel);
        $this->entityManager->flush();

        return $hotel;
    }

    public function getHotel(int $id): ?Hotel
    {
        return $this->hotelRepository->find($id);
    }

    public function getAllHotels(): array
    {
        return $this->hotelRepository->findAll();
    }

    public function updateHotel(int $id, array $hotelData): ?Hotel
    {
        $hotel = $this->hotelRepository->find($id);
        if ($hotel) {
            $hotel->setName($hotelData['name']);
            $hotel->setName($hotelData['name']);
            $hotel->setCity($hotelData['city']);
            $hotel->setCountry($hotelData['country']);

            $this->entityManager->flush();
        }

        return $hotel;
    }

    public function deleteHotel(int $id): void
    {
        $hotel = $this->hotelRepository->find($id);
        if ($hotel) {
            $this->entityManager->remove($hotel);
            $this->entityManager->flush();
        }
    }
}
