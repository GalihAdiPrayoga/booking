<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AirportsRequest;
use App\Http\Requests\UpdateAirportsRequest;
use App\Http\Resources\AirportsResource;
use App\Repositories\AirportsRepository;
use App\Services\AirportsService;
use Illuminate\Support\Facades\DB;


class AirportsController extends Controller
{
    private AirportsService $airportsService;
    private AirportsRepository $airportsRepository;

    public function __construct(AirportsService $airportsService, AirportsRepository $airportsRepository)
    {
        $this->airportsService = $airportsService;
        $this->airportsRepository = $airportsRepository;
    }
    
    public function index()
    {
       try {
            return ResponseHelper::success(
                AirportsResource::collection($this->airportsRepository->get()),
                trans('alert.fetch_data_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    public function store(AirportsRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $this->airportsService->mapStore($request);
            $airport = $this->airportsRepository->store($payload);

            DB::commit();
            return ResponseHelper::success(new AirportsResource($airport), 'Bandara berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.add_failed') . ' => ' . $th->getMessage());
        
    }
    }
    public function show(string $id)
    {
      try{
        return ResponseHelper::success(new AirportsResource($this->airportsRepository->show($id)), trans('Detail bandara berhasil diambil'));          
      } catch(\Throwable $th) {
        return ResponseHelper::error(message: $th->getMessage());
    }
    }

    public function update(UpdateAirportsRequest $request,  Airport $airport)
    {
        DB::beginTransaction();
        try {
            $payload = $this->airportsService->mapUpdate($request->validated(), $airport);
            $airport->update($payload);

            DB::commit();
            return ResponseHelper::success(new AirportsResource($airport), 'Bandara berhasil diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.update_failed') . '=>'. $th->getMessage());
        }
    }

    public function destroy(Airport $airports)
    {
        DB::beginTransaction();
        try {
            $airports->delete();

            DB::commit();
            return ResponseHelper::success(new AirportsResource($airports), trans ('Bandara berhasil dihapus'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.delete_failed') . '=>'. $th->getMessage());
    }
}
}