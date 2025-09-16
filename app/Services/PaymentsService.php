<?php

namespace App\Services;

use App\Models\Payments;
use App\Models\Bookings;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PaymentsService
{
    /**
     * Create a new payment record for a booking
     *
     * @param int $bookingId
     * @param float $amount
     * @param string $method
     * @return Payment
     * @throws \Throwable
     */
    public function createPayment(int $bookingId, float $amount, string $method): Payments
    {
        return DB::transaction(function () use ($bookingId, $amount, $method) {
            $booking = Bookings::findOrFail($bookingId);

            // Pastikan booking belum ada payment
            if ($booking->payment) {
                throw new InvalidArgumentException('Payment untuk booking ini sudah ada.');
            }

            $payment = Payments::create([
                'booking_id' => $bookingId,
                'amount' => $amount,
                'payment_method' => $method,
                'status' => 'unpaid',
            ]);

            return $payment;
        });
    }

    /**
     * Mark payment as paid
     *
     * @param int $paymentId
     * @return Payments
     */
    public function markAsPaid(int $paymentId): Payments
    {
        $payment = Payments::findOrFail($paymentId);

        if ($payment->status === 'paid') {
            throw new InvalidArgumentException('Payment sudah dibayar.');
        }

        $payment->update(['status' => 'paid']);
        return $payment;
    }

    /**
     * Mark payment as failed
     *
     * @param int $paymentId
     * @return Payments
     */
    public function markAsFailed(int $paymentId): Payments
    {
        $payment = Payments::findOrFail($paymentId);

        if ($payment->status === 'failed') {
            throw new InvalidArgumentException('Payment sudah gagal.');
        }

        $payment->update(['status' => 'failed']);
        return $payment;
    }

    /**
     * Check status of payment by booking ID
     *
     * @param int $bookingId
     * @return string|null
     */
    public function checkPaymentStatus(int $bookingId): ?string
    {
        $payment = Payments::where('booking_id', $bookingId)->first();
        return $payment ? $payment->status : null;
    }

    /**
     * Get detailed payment info including booking and passengers
     *
     * @param int $bookingId
     * @return Payments|null
     */
    public function getPaymentDetails(int $bookingId): ?Payments
    {
        return Payments::with('booking.passengers')->where('booking_id', $bookingId)->first();
    }
}
