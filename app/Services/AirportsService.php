<?php

namespace App\Services;

use App\Http\Requests\AirportsRequest;
use App\Http\Resources\AirportsResource;
use App\Interfaces\AirportsInterface;
use App\Helpers\ResponseHelper;

class AirportsService
{
    protected AirportsInterface $airportsRepository;

    public function __construct(AirportsInterface $airportsRepository)
    {
        $this->airportsRepository = $airportsRepository;
    }

    public function mapStore(AirportsRequest $request): array
    {
        $data = $request->validated();

        return [
            'name' => $data['name'] ?? null,
            'code' => $data['code'] ?? null,
            'city' => $data['city'] ?? null,
            'country' => $data['country'] ?? null,
        ];
    }

    public function mapUpdate(array $validated, $airport): array
    {
        return [
            'name' => $validated['name'] ?? $airport->name,
            'code' => $validated['code'] ?? $airport->code,
            'city' => $validated['city'] ?? $airport->city,
            'country' => $validated['country'] ?? $airport->country,
        ];
    }

    public function getAll()
    {
        $data = $this->airportsRepository->get();
        return ResponseHelper::success(AirportsResource::collection($data), 'List bandara berhasil diambil');
    }

    public function store(AirportsRequest $request)
    {
        $payload = $this->mapStore($request);
        $data = $this->airportsRepository->store($payload);
        return ResponseHelper::success(new AirportsResource($data), 'Bandara berhasil ditambahkan');
    }

    public function show($id)
    {
        $data = $this->airportsRepository->show($id);
        return ResponseHelper::success(new AirportsResource($data), 'Detail bandara berhasil diambil');
    }

    public function update(AirportsRequest $request, $id)
    {
        $airport = $this->airportsRepository->show($id); 
        $payload = $this->mapUpdate($request->validated(), $airport);
        $this->airportsRepository->update($id, $payload);
        return ResponseHelper::success(null, 'Bandara berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->airportsRepository->delete($id);
        return ResponseHelper::success(null, 'Bandara berhasil dihapus');
    }
}
