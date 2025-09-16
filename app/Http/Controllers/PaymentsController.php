<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\PaymentsRequest;
use App\Http\Resources\PaymentsResource;
use App\Services\PaymentsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    private PaymentsService $paymentsService;

    public function __construct(PaymentsService $paymentsService)
    {
        $this->paymentsService = $paymentsService;
    }

    /**
     * Create a new payment for a booking
     */
    public function store(PaymentsRequest $request)
    {
        if (!Auth::check()) {
            return ResponseHelper::error('Unauthorized', 401);
        }

        DB::beginTransaction();
        try {
            $payment = $this->paymentsService->createPayment(
                $request->booking_id,
                $request->amount,
                $request->payment_method
            );

            DB::commit();
            return ResponseHelper::success(
                new PaymentsResource($payment),
                'Payment created successfully.'
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error('Failed to create payment: ' . $th->getMessage());
        }
    }

    /**
     * Mark payment as paid
     */
    public function pay(int $id)
    {
        DB::beginTransaction();
        try {
            $payment = $this->paymentsService->markAsPaid($id);

            DB::commit();
            return ResponseHelper::success(
                new PaymentsResource($payment),
                'Payment marked as paid.'
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error('Failed to mark payment as paid: ' . $th->getMessage());
        }
    }

    /**
     * Mark payment as failed
     */
    public function fail(int $id)
    {
        DB::beginTransaction();
        try {
            $payment = $this->paymentsService->markAsFailed($id);

            DB::commit();
            return ResponseHelper::success(
                new PaymentsResource($payment),
                'Payment marked as failed.'
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error('Failed to mark payment as failed: ' . $th->getMessage());
        }
    }

    /**
     * Check payment status for a booking
     */
    public function status(int $bookingId)
    {
        try {
            $status = $this->paymentsService->checkPaymentStatus($bookingId);

            if (!$status) {
                return ResponseHelper::error('Payment not found', 404);
            }

            return ResponseHelper::success(['status' => $status]);
        } catch (\Throwable $th) {
            return ResponseHelper::error('Failed to check payment status: ' . $th->getMessage());
        }
    }

    /**
     * Show payment details by booking
     */
    public function showByBooking(int $bookingId)
    {
        try {
            $payment = $this->paymentsService->getPaymentDetails($bookingId);

            if (!$payment) {
                return ResponseHelper::error('Payment not found', 404);
            }

            return ResponseHelper::success(new PaymentsResource($payment));
        } catch (\Throwable $th) {
            return ResponseHelper::error('Failed to fetch payment: ' . $th->getMessage());
        }
    }
}
