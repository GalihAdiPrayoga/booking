<?php

namespace App\Services;

use App\Repositories\BookingsRepository;
use App\Repositories\BookingPassengersRepository;
use App\Models\Bookings;
use App\Models\BookingPassengers;

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

        /**
     * Cek apakah tiket tersedia
     */
    public function isTicketAvailable(int $ticketId, string $date): bool
    {
        return !BookingPassengers::where('ticket_id', $ticketId)
            ->whereHas('booking', fn($q) => $q->whereDate('booking_date', $date))
            ->exists();
    }

    /**
     * Ambil status beberapa tiket pada tanggal tertentu
     */
    public function getTicketsStatus(array $ticketIds, string $date): array
    {
        $result = [];

        foreach ($ticketIds as $ticketId) {
            $result[] = [
                'ticket_id' => $ticketId,
                'date'      => $date,
                'status'    => $this->isTicketAvailable($ticketId, $date) ? 'available' : 'unavailable',
            ];
        }

        return $result;
    }

}