<?php

namespace App\Services;

use App\Models\Bookings;
use App\Models\BookingPassengers;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class TicketsService
{
    /**
     * Cek apakah tiket tersedia di tanggal tertentu
     *
     * @param int $ticketId
     * @param string $date (format: Y-m-d)
     * @return bool
     */
    public function isAvailable(int $ticketId, string $date): bool
    {
        return !BookingPassengers::where('ticket_id', $ticketId)
            ->whereHas('booking', function ($q) use ($date) {
                $q->whereDate('booking_date', $date);
            })
            ->exists();
    }

    /**
     * Membuat booking tiket + passengers
     *
     * @param int $userId
     * @param string $date
     * @param array $passengers contoh:
     * [
     *   ['ticket_id' => 1, 'name' => 'Budi', 'identity_number' => '123'],
     *   ['ticket_id' => 2, 'name' => 'Ani', 'identity_number' => '456'],
     * ]
     *
     * @return Bookings
     */
    public function bookTicket(int $userId, string $date, array $passengers): Bookings
    {
        return DB::transaction(function () use ($userId, $date, $passengers) {
            // Buat data booking utama
            $booking = Bookings::create([
                'user_id'      => $userId,
                'booking_date' => $date,
                'status'       => 'confirmed',
            ]);

            foreach ($passengers as $p) {
                // Cek apakah tiket ini masih tersedia
                if (!$this->isAvailable($p['ticket_id'], $date)) {
                    throw new InvalidArgumentException("Tiket {$p['ticket_id']} sudah dibooking di tanggal {$date}");
                }

                // Simpan passenger
                $booking->passengers()->create([
                    'ticket_id'       => $p['ticket_id'],
                    'name'            => $p['name'] ?? null,
                    'identity_number' => $p['identity_number'] ?? null,
                ]);
            }

            return $booking;
        });
    }

    /**
     * Ambil semua tiket + status (available/unavailable) untuk tanggal tertentu
     *
     * @param array $ticketIds
     * @param string $date
     * @return array
     */
    public function getTicketsStatus(array $ticketIds, string $date): array
    {
        $result = [];

        foreach ($ticketIds as $ticketId) {
            $result[] = [
                'ticket_id' => $ticketId,
                'date'      => $date,
                'status'    => $this->isAvailable($ticketId, $date) ? 'available' : 'unavailable',
            ];
        }

        return $result;
    }
}
