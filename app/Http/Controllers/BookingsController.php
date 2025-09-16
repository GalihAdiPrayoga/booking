<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Helpers\ResponseHelper;
use App\Http\Requests\BookingsRequest;
use App\Http\Requests\UpdateBookingsRequest;
use App\Http\Resources\BookingsResource;
use App\Repositories\BookingsRepository;
use App\Services\BookingsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class BookingsController extends Controller
{
    private BookingsService $bookingsService;
    private BookingsRepository $bookingsRepository;

    public function __construct(BookingsService $bookingsService, BookingsRepository $bookingsRepository)
    {
        $this->bookingsService = $bookingsService;
        $this->bookingsRepository = $bookingsRepository;
    }

    public function index()
    {
        try {
            $bookings = $this->bookingsRepository->get();
            return ResponseHelper::success(
                BookingsResource::collection($bookings), 
                trans('alert.fetch_data_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    public function store(BookingsRequest $request)
{
    if (!Auth::check()) {
        return ResponseHelper::error(
            message: trans('alert.unauthenticated'),
            code: 401
        );
    }

    DB::beginTransaction();
    try {
        $booking = $this->bookingsService->createWithPassengers(
            Auth::id(),
            $request->booking_date, 
            $request->passengers // Tidak perlu kirim ticket_id terpisah
        );

        DB::commit();
        return ResponseHelper::success(
            new BookingsResource($booking->load('passengers')), 
            trans('alert.add_success')
        );
    } catch (\Throwable $th) {
        DB::rollBack();
        return ResponseHelper::error(
            message: trans('alert.add_failed') . ' => ' . $th->getMessage()
        );
    }
}
    public function show(Bookings $booking)
    {
        try {
            if (Auth::check() && $booking->user_id !== Auth::id()) {
                return ResponseHelper::error(
                    message: trans('alert.unauthorized'),
                    code: 403
                );
            }
            
            return ResponseHelper::success(
                new BookingsResource($booking->load('passengers'))
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    public function update(UpdateBookingsRequest $request, Bookings $booking)
    {
        // Memastikan user hanya bisa mengupdate booking miliknya sendiri
        if (Auth::check() && $booking->user_id !== Auth::id()) {
            return ResponseHelper::error(
                message: trans('alert.unauthorized'),
                code: 403
            );
        }

        DB::beginTransaction();
        try {
            $updatedBooking = $this->bookingsRepository->update($booking, $request->validated());
            
            DB::commit();
            return ResponseHelper::success(
                new BookingsResource($updatedBooking->load('passengers')), 
                trans('alert.update_success')
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(
                message: trans('alert.update_failed') . ' => ' . $th->getMessage()
            );
        }
    }

    public function destroy(Bookings $booking)
    {
        // Memastikan user hanya bisa menghapus booking miliknya sendiri
        if (Auth::check() && $booking->user_id !== Auth::id()) {
            return ResponseHelper::error(
                message: trans('alert.unauthorized'),
                code: 403
            );
        }

        DB::beginTransaction();
        try {
            $this->bookingsRepository->delete($booking);

            DB::commit();
            return ResponseHelper::success(message: trans('alert.delete_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(
                message: trans('alert.delete_failed') . ' => ' . $th->getMessage()
            );
        }
    }

        /**
     * Cek ketersediaan tiket di tanggal tertentu
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date'      => 'required|date',
            'ticket_id' => 'required|integer|exists:tickets,id',
        ]);

        try {
            $isAvailable = $this->bookingsService->isTicketAvailable(
                $request->ticket_id,
                $request->date
            );

            return ResponseHelper::success([
                'ticket_id' => $request->ticket_id,
                'date'      => $request->date,
                'available' => $isAvailable,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    /**
     * Ambil status semua tiket untuk tanggal tertentu
     */
    public function ticketsStatus(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'integer|exists:tickets,id',
        ]);

        try {
            $status = $this->bookingsService->getTicketsStatus(
                $request->ticket_ids,
                $request->date
            );

            return ResponseHelper::success($status);
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }
}