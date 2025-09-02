    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Helpers\PaginateHelper;
    use App\Helpers\ResponseHelper;
    use App\Http\Requests\LoginRequest;
    use App\Http\Requests\UserRequest;
    use App\Http\Requests\UpdateUserRequest;
    use App\Http\Resources\UserPaginateResource;
    use App\Http\Requests\UpdateProfileRequest;
    use App\Http\Resources\UserResource;
    use App\Models\User;
    use App\Repositories\UserRepository;
    use App\Services\ProfilService;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class ProfilController extends Controller
    {
        protected $profilService;

        public function __construct(ProfilService $profilService)
        {
            $this->profilService = $profilService;
        }

        public function updateProfile(UpdateProfileRequest $request): JsonResponse
        {
            DB::beginTransaction();
            try {
                $user = Auth::user();
                $payload = $this->profilService->mapUpdateProfile($request, $user);
                $user->update($payload);

                DB::commit();
                return ResponseHelper::success(new UserResource($user), trans('alert.update_success'));
            } catch (\Throwable $th) {
                DB::rollBack();
                return ResponseHelper::error(message: trans('alert.update_failed') . ' => ' . $th->getMessage());
            }
        }
    }
