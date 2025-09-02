<?php

namespace App\Services;

use App\Repositories\BookingsRepository;
use App\Repositories\BookingPassengersRepository;
use App\Models\bookings;

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

    public function createWithPassengers(int $userId, string $bookingDate, array $passengers): bookings
    {
        // simpan booking utama
        $booking = $this->bookingsRepository->store([
            'user_id' => $userId,
            'booking_date' => $bookingDate,
            'status' => 'pending',
        ]);

        // simpan banyak penumpang
        foreach ($passengers as $p) {
            $this->bookingPassengersRepository->store([
                'booking_id' => $booking->id,
                'name' => $p['name'],
                'identity_number' => $p['identity_number'],
                'seat_number' => $p['seat_number'],
            ]);
        }

        return $booking;
    }
}
