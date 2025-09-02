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

    public function mapStore(UserRequest $request): array
    {
        $data = $request->validated();

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->upload('users', $request->file('photo'));
        }

        return $data;
    }

    public function mapUpdate(UpdateUserRequest $request, User $user): array
    {
        $data = $request->validated();

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user?->photo) {
                $this->remove($user->photo);
            }
            $data['photo'] = $this->upload('users', $request->file('photo'));
        }

        return $data;
    }

    public function removeImage(User $user): bool
    {
        if ($user?->photo) {
            $this->remove($user->photo);
        }

        return true;
    }

    /**
     * Handle sign in via api
     *
     * @param LoginRequest $request
     * @return object
     */
    public function handleSignIn(LoginRequest $request): object
    {
        $validated = $request->validated();

        $remember = $request->remember_me ?? false;
        unset($validated['remember_me']); // fix key name

        if (!Auth::attempt($validated, $remember)) {
            return ResponseHelper::error(null, trans('auth.failed'), Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        return (object) [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
            'role' => $user->roles->pluck('name')->first(),
        ];
    }
}
