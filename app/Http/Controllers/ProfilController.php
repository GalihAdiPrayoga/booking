<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\ProfilService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    private ProfilService $profilService;

    public function __construct(ProfilService $profilService)
    {
        $this->profilService = $profilService;
    }

    /**
     * Get user profile
     */
    public function show(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return ResponseHelper::error(
                    message: trans('auth.unauthenticated'),
                    code: 401
                );
            }

            return ResponseHelper::success(
                new UserResource($user),
                trans('alert.fetch_data_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    /**
     * Update user profile (only name and photo)
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return ResponseHelper::error(
                    message: trans('auth.unauthenticated'),
                    code: 401
                );
            }

            $updatedUser = $this->profilService->updateProfile($user, $request->validated());

            return ResponseHelper::success(
                new UserResource($updatedUser),
                trans('alert.update_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(
                message: trans('alert.update_failed')
            );
        }
    }

    /**
     * Remove user photo
     */
    public function removePhoto(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return ResponseHelper::error(
                    message: trans('auth.unauthenticated'),
                    code: 401
                );
            }

            $updatedUser = $this->profilService->removePhoto($user);

            return ResponseHelper::success(
                new UserResource($updatedUser),
                trans('alert.photo_removed')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(
                message: trans('alert.photo_remove_failed')
            );
        }
    }
}