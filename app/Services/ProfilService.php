<?php

namespace App\Services;

use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfilService
{
    use UploadTrait;

    /**
     * Map update profile data - hanya name dan photo
     */
    public function mapUpdate(array $validatedData): array
    {
        $data = [];

        // Hanya proses name jika ada
        if (isset($validatedData['name'])) {
            $data['name'] = $validatedData['name'];
        }

        // Hanya proses photo jika ada file
        if (isset($validatedData['photo'])) {
            try {
                $data['photo'] = $this->upload('users', $validatedData['photo']);
            } catch (\Exception $e) {
                Log::error('Photo upload failed: ' . $e->getMessage());
                throw $e;
            }
        }

        return $data;
    }

    /**
     * Remove user photo
     */
    public function removePhoto(int $userId): void
    {
        // Logic untuk remove photo akan dihandle oleh repository
        // Service hanya memastikan payload untuk remove photo
    }
}