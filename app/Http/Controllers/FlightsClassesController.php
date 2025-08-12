<?php

namespace App\Http\Controllers;

use App\Models\FlightsClasses; 
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseHelper;
use App\Services\FlightsClassesService;
use App\Http\Requests\FlightsClassesRequest;
use App\Repositories\FlightsClassesRepository;
use App\Http\Resources\FlightsClassesResource;

class FlightsClassesController extends Controller
{
    private FlightsClassesService $flightsClassesService;
    private FlightsClassesRepository $flightsClassesRepository;

    public function __construct(FlightsClassesService $flightsClassesService, FlightsClassesRepository $flightsClassesRepository)
    {
        $this->flightsClassesService = $flightsClassesService;
        $this->flightsClassesRepository = $flightsClassesRepository;
    }

    public function index()
    {
        try{
            return ResponseHelper::success(
                FlightsClassesResource::collection($this->flightsClassesRepository->get()),
                 trans('List kelas penerbangan berhasil diambil')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
    }
    }

    public function store(FlightsClassesRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $this->flightsClassesService->mapStore($request->validated());
            $flightsClass = $this->flightsClassesRepository->store($payload);

            DB::commit();
            return ResponseHelper::success(new FlightsClassesResource($flightsClass), 'Kelas penerbangan berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: 'Gagal menambahkan kelas penerbangan: ' . $th->getMessage());
        }
    }

    public function show(flightsclasses $flightsclasses)
    {
        try {
            return ResponseHelper::success(new FlightsClassesResource($this->flightsClassesRepository->show($flightsclasses->id)), 'Detail kelas penerbangan berhasil diambil');
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    public function update(FlightsClassesRequest $request, flightsclasses $flightsclasses)
    {
        DB::beginTransaction();
        try {
            $payload = $this->flightsClassesService->mapUpdate($request->validated(), $flightsclasses);
            $updatedFlightsClass = $this->flightsClassesRepository->update($payload, ['id' => $flightsclasses->id]);

            DB::commit();
            return ResponseHelper::success(new FlightsClassesResource($updatedFlightsClass), 'Kelas penerbangan berhasil diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: 'Gagal memperbarui kelas penerbangan: ' . $th->getMessage());
        }
    }

    public function destroy(flightsclasses $flightsclasses)
    {
        DB::beginTransaction();
        try {
            $flightsclasses->delete();
            DB::commit();
            return ResponseHelper::success(null, 'Kelas penerbangan berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: 'Gagal menghapus kelas penerbangan: ' . $th->getMessage());
        }
    }
}
