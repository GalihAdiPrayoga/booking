<?php

namespace App\Services;

use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfilService
{
    use UploadTrait;

    /**
     * Update user profile (name & photo)
     *
     * @param User $user
     * @param array $validatedData
     * @return User
     */
    public function updateProfile(User $user, array $validatedData): User
    {
        $data = $this->mapUpdate($validatedData);

        // Hapus foto lama jika ada
        if (isset($data['photo']) && $user->photo) {
            Storage::delete($user->photo);
        }

        $user->update($data);
        return $user;
    }

    /**
     * Remove user photo
     *
     * @param User $user
     * @return User
     */
    public function removePhoto(User $user): User
    {
        if ($user->photo) {
            Storage::delete($user->photo);
            $user->photo = null;
            $user->save();
        }

        return $user;
    }

    /**
     * Map update profile data - hanya name dan photo
     */
    public function mapUpdate(array $validatedData): array
    {
        $data = [];

        if (isset($validatedData['name'])) {
            $data['name'] = $validatedData['name'];
        }

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
}
