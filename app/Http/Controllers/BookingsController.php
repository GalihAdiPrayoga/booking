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
            return ResponseHelper::success(
                BookingsResource::collection($this->bookingsRepository->get()),
                trans('alert.fetch_data_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    public function store(BookingsRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $this->bookingsService->mapStore($request->validated());
            $bookings = $this->bookingsRepository->store($payload);

            DB::commit();
            return ResponseHelper::success(new BookingsResource($bookings), trans('alert.add_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.add_failed') . ' => ' . $th->getMessage());
        }
    }

    public function show(Bookings $bookings)
    {
        return ResponseHelper::success(new BookingsResource($bookings));
    }

    public function update(UpdateBookingsRequest $request, Bookings $bookings)
    {
        DB::beginTransaction();
        try {
            $payload = $this->bookingsService->mapUpdate($request->validated());
            $this->bookingsRepository->update($bookings, $payload);

            DB::commit();
            return ResponseHelper::success(new BookingsResource($bookings), trans('alert.update_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.update_failed') . ' => ' . $th->getMessage());
        }
    }

    public function destroy(Bookings $bookings)
    {
        DB::beginTransaction();
        try {
            $this->bookingsRepository->delete($bookings);

            DB::commit();
            return ResponseHelper::success(message: trans('alert.delete_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.delete_failed') . ' => ' . $th->getMessage());
        }
    }
}
