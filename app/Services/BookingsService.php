<?php

namespace App\Services;

use App\Repositories\BookingsRepository;
use App\Repositories\BookingPassengersRepository;
use App\Models\Bookings;

class BookingsService
{
    private BookingsRepository $bookingsRepository;
    private BookingPassengersRepository $bookingPassengersRepository;

    public function __construct(
        BookingsRepository $bookingsRepository,
        BookingPassengersRepository $bookingPassengersRepository
    ) {
        $this->bookingsRepository = $bookingsRepository;
        $this->bookingPassengersRepository = $bookingPassengersRepository;
    }

    public function createWithPassengers(int $userId, string $bookingDate, array $passengers): Bookings
    {
        // Simpan booking utama
        $booking = $this->bookingsRepository->store([
            'user_id' => $userId,
            'booking_date' => $bookingDate,
            'status' => 'pending',
        ]);

        // Simpan banyak penumpang
        foreach ($passengers as $passenger) {
            $this->bookingPassengersRepository->store([
                'booking_id' => $booking->id,
                'ticket_id' => $passenger['ticket_id'],
                'name' => $passenger['name'],
                'identity_number' => $passenger['identity_number'],
            ]);
        }

        return $booking;
    }
}