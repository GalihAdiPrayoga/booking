<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserService
{
    use UploadTrait;

    public function mapUpdateProfile($request, User $user): array
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($user?->photo) {
                $this->remove($user->photo);
            }
            $data['photo'] = $this->upload('users', $request->file('photo'));
        }

        return $data;
    }
}
