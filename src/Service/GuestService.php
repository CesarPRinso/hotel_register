<?php

namespace App\Service;

use App\Entity\Guest;
use App\Repository\GuestRepository;
use Doctrine\ORM\EntityManagerInterface;

class GuestService
{
    private $entityManager;
    private $guestRepository;

    public function __construct(EntityManagerInterface $entityManager, GuestRepository $guestRepository)
    {
        $this->entityManager = $entityManager;
        $this->guestRepository = $guestRepository;
    }

    public function createGuest(array $guestData): Guest
    {
        $guest = new Guest();
        $guest->setName($guestData['name']);
        $guest->setSurname($guestData['surname']);
        $guest->setDateOfBirth(new \DateTime($guestData['dateOfBirth']));
        $guest->setGender($guestData['gender']);
        $guest->setPassportNumber($guestData['passportNumber']);
        $guest->setCountry($guestData['country']);
        $guest->setRegistrationId($guestData['registrationId']);

        $this->entityManager->persist($guest);
        $this->entityManager->flush();

        return $guest;
    }

    public function getGuest(int $guestId): ?Guest
    {
        return $this->guestRepository->find($guestId);
    }

    public function getAllGuests(): array
    {
        return $this->guestRepository->findAll();
    }

    public function updateGuest(int $guestId, array $guestData): ?Guest
    {
        $guest = $this->guestRepository->find($guestId);
        if ($guest) {
            $guest->setName($guestData['name']);
            $guest->setSurname($guestData['surname']);
            $guest->setDateOfBirth(new \DateTime($guestData['dateOfBirth']));
            $guest->setGender($guestData['gender']);
            $guest->setPassportNumber($guestData['passportNumber']);
            $guest->setCountry($guestData['country']);
            $guest->setRegistrationId($guestData['registrationId']);

            $this->entityManager->flush();
        }

        return $guest;
    }

    public function deleteGuest(int $guestId): void
    {
        $guest = $this->guestRepository->find($guestId);
        if ($guest) {
            $this->entityManager->remove($guest);
            $this->entityManager->flush();
        }
    }

    public function getRegistrationsByGuest(int $guestId): array
    {
        $query = $this->entityManager->createQuery(
            'SELECT r 
             FROM App\Entity\Registration r
             WHERE r.guest = :guestId'
        )->setParameter('guestId', $guestId);

        return $query->getResult();
    }

    public function getRegistrationStatusesByGuest(int $guestId): array
    {
        $registrations = $this->getRegistrationsByGuest($guestId);
        $statuses = [];
        foreach ($registrations as $registration) {
            $statuses[] = [
                'registrationId' => $registration->getId(),
                'status' => $registration->getStatus(),
            ];
        }
        return $statuses;
    }
}
