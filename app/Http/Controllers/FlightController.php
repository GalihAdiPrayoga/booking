<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseHelper;
use App\Services\FlightService;
use App\Http\Requests\FlightRequest;
use App\Repositories\FlightRepository;
use App\Http\Resources\FlightResource;

class FlightController extends Controller
{

   private FlightService $flightService;
   private  FlightRepository $flightRepository;

  public function __construct(FlightService $flightService, FlightRepository $flightRepository)
    {
        $this->flightService = $flightService;
        $this->flightRepository = $flightRepository;
    }   

    public function index()
    {
   
        try {
            return ResponseHelper::success(
                FlightResource::collection($this->flightRepository->get()),
                trans('alert.fetch_data_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    public function store(FlightRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $this->flightService->mapStore($request->validated());
            $flight = $this->flightRepository->store($payload);

            DB::commit();
            return ResponseHelper::success(new FlightResource($flight), 'Flight successfully added');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: 'Failed Added Flight '. $th->getMessage());
    }

    }
    public function show($id)
    {
          try {
            return ResponseHelper::success(new FlightResource($this->flightRepository->show($id)), 'Detail penerbangan');
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }   
    }

    public function update(FlightRequest $request, flight $flight)
    {
         DB::beginTransaction();
        try {
            $payload = $this->flightService->mapUpdate($request->validated());
            $this->flightRepository->update($payload, $flight->id);

            DB::commit();
            return ResponseHelper::success(new FlightResource($flight), 'Penerbangan berhasil diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: 'Gagal memperbarui penerbangan => ' . $th->getMessage());
        }
    }

    public function destroy(flight $flight)
    {
           DB::beginTransaction();
        try {
            $flight->delete();
            DB::commit();
            return ResponseHelper::success(new FlightResource($flight), 'Penerbangan berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: 'Gagal menghapus penerbangan => ' . $th->getMessage());
        }
    }
}
