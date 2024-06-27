<?php

namespace App\Service;

use App\Entity\Registration;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationService
{
    private $entityManager;
    private $registrationRepository;

    public function __construct(EntityManagerInterface $entityManager, RegistrationRepository $registrationRepository)
    {
        $this->entityManager = $entityManager;
        $this->registrationRepository = $registrationRepository;
    }

    public function createRegistration(array $registrationData): Registration
    {
        $registration = new Registration();
        $registration->setHotel($registrationData['hotel']);
        $registration->setGuest($registrationData['guest']);
        $registration->setCheckInDate(new \DateTime($registrationData['checkInDate']));
        $registration->setCheckOutDate(new \DateTime($registrationData['checkOutDate']));
        $registration->setStatus($registrationData['status']);

        $this->entityManager->persist($registration);
        $this->entityManager->flush();

        return $registration;
    }

    public function getRegistration(int $registrationId): ?Registration
    {
        return $this->registrationRepository->find($registrationId);
    }

    public function getAllRegistrations(): array
    {
        return $this->registrationRepository->findAll();
    }

    public function updateRegistration(int $registrationId, array $registrationData): ?Registration
    {
        $registration = $this->registrationRepository->find($registrationId);
        if ($registration) {
            $registration->setHotel($registrationData['hotel']);
            $registration->setGuest($registrationData['guest']);
            $registration->setCheckInDate(new \DateTime($registrationData['checkInDate']));
            $registration->setCheckOutDate(new \DateTime($registrationData['checkOutDate']));
            $registration->setStatus($registrationData['status']);

            $this->entityManager->flush();
        }

        return $registration;
    }

    public function deleteRegistration(int $registrationId): void
    {
        $registration = $this->registrationRepository->find($registrationId);
        if ($registration) {
            $this->entityManager->remove($registration);
            $this->entityManager->flush();
        }
    }

    public function getRegistrationsByHotel(int $hotelId): array
    {
        return $this->registrationRepository->findBy(['hotel' => $hotelId]);
    }

    public function getRegistrationStatusesByHotel(int $hotelId): array
    {
        $registrations = $this->getRegistrationsByHotel($hotelId);
        $statuses = [];
        foreach ($registrations as $registration) {
            $statuses[] = [
                'registrationId' => $registration->getId(),
                'status' => $registration->getStatus(),
            ];
        }
        return $statuses;
    }

    public function getUsersByHotelAndDateRange(int $hotelId, string $startDate, string $endDate): array
    {
        $query = $this->entityManager->createQuery(
            'SELECT r.guest 
             FROM App\Entity\Registration r
             WHERE r.hotel = :hotelId 
             AND r.checkInDate >= :startDate 
             AND r.checkOutDate <= :endDate'
        )->setParameters([
            'hotelId' => $hotelId,
            'startDate' => new \DateTime($startDate),
            'endDate' => new \DateTime($endDate),
        ]);

        return $query->getResult();
    }
}
