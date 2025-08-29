<?php

namespace App\Http\Controllers;

use App\Helpers\PaginateHelper;
use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserPaginateResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    private UserRepository $user;
    private UserService $userService;

    public function __construct(UserRepository $user, UserService $userService)
    {
        $this->user = $user;
        $this->userService = $userService;
    }

    /**
     * Get Current User using auth token
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        try {
            return ResponseHelper::success(UserResource::collection($this->user->get()), trans('alert.get_current_user'));
        }catch(\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $store = $this->userService->mapStore($request);
            $user = $this->user->store($store);

            DB::commit();
            return ResponseHelper::success(data:new UserResource ($user), message: trans('alert.add_success'));
        }catch(\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.add_failed') . " => " . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return ResponseHelper::success($this->user->show($id), trans('alert.get_current_user'));
        }catch(\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $payload = $this->userService->mapUpdate($request, $user);
            $user->update($payload);

            DB::commit();
            return ResponseHelper::success(data:new UserResource ($user), message: trans('alert.user_soft_delete_success'));
        }catch(\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.update_failed') . " => " . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $this->userService->removeImage($user);
            $user->delete();

            DB::commit();
            return ResponseHelper::success(data:new UserResource ($user), message: trans('alert.user_soft_delete_success'));
        }catch(\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.user_soft_delete_failed') . " => " . $th->getMessage());
        }
    }

    /**
     * Get list user with paginate
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function listPaginate(Request $request): JsonResponse
    {
        try {
            $users = $this->user->customPaginate($request->paginate ?? 10);

        return ResponseHelper::success(
            UserPaginateResource::make($users, PaginateHelper::getPaginate($users)),
            trans('alert.fetch_data_success'),
            pagination: true);
        }catch(\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(LoginRequest $request)
    {
        try {
            return ResponseHelper::success($this->userService->handleSignIn($request), message: trans('alert.add_success'));
        }catch(\Throwable $th) {
            return ResponseHelper::error(message: trans('alert.add_failed') . " => " . $th->getMessage());
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->currentAccessToken()->delete();
            return ResponseHelper::success(new UserResource($user), message: trans('auth.logout_success'));
        }catch(\Throwable $th) {
            return ResponseHelper::error(message: $th->getMessage());
        }

    }

    public function restore($id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::withTrashed()->findOrFail($id);

            $user->restore();

            DB::commit();
            return ResponseHelper::success( new UserResource($user), message: trans('alert.user_restore_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error(message: trans('alert.user_restore_failed') . " => " . $th->getMessage());
        }
    }

    }
