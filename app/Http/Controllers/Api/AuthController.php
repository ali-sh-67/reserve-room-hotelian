<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\LogLogin;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

/**
 *
 */
class AuthController extends Controller
{
    use HasApiTokens;

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {

            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            if (!$user) throw new Exception('ثبت نام ناموفق لطفا دوباره تلاش کنید.', 400);

            $token = $user->createToken('Personal Access Token');

            $data['token']['access_token'] = $token->accessToken;
            $data['token']['token_type'] = 'Bearer';
            $data['token']['expires_at'] = Carbon::parse($token->token->expires_at)->toDateTimeString();
            $data['user'] = $user;

            $this->insertLogLogin(LogLogin::$OPERATION_REGISTER);

            return successResponse($data, ['ثبت نام با موفقیت انجام شد و تا لحظاتی دیگر بطور خودکار وارد میشوید.'], 200);
        } catch (Exception $e) {
            $this->insertLogLogin(LogLogin::$OPERATION_REGISTER, false, (array)$e->getMessage());
            return errorResponse($e->getCode(), (array)$e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only(['username', 'password']);
            if (!Auth::attempt($credentials)) throw new Exception('نام کاربری یا پسورد اشتباه است مجدد تلاش کنید.', 401);

            $user = $request->user();

            $token = $user->createToken('Personal Access Token');

            $data['token']['access_token'] = $token->accessToken;
            $data['token']['token_type'] = 'Bearer';
            $data['token']['expires_at'] = Carbon::parse($token->token->expires_at)->toDateTimeString();
            $data['user'] = $user;

            $this->insertLogLogin(LogLogin::$OPERATION_LOGIN);

            return successResponse($data, ['ثبت نام با موفقیت انجام شد و تا لحظاتی دیگر بطور خودکار وارد میشوید.'], 200);

        } catch (Exception $e) {
            $this->insertLogLogin(LogLogin::$OPERATION_LOGIN, false, (array)$e->getMessage());
            return errorResponse($e->getCode(), (array)$e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {

            $request->user()->token()->revoke();

            $this->insertLogLogin(LogLogin::$OPERATION_LOGOUT);

            return successResponse([], ['توکن با موفقیت حذف شد'], 200);

        } catch (Exception $e) {
            $this->insertLogLogin(LogLogin::$OPERATION_LOGOUT, false, (array)$e->getMessage());
            return errorResponse($e->getCode(), (array)$e->getMessage());
        }
    }

    /**
     * @param string $operation
     * @param bool $success
     * @param array $error
     * @return JsonResponse|bool
     */
    public function insertLogLogin(string $operation, bool $success = true, array $error = []): JsonResponse|bool
    {
        try {

            $login = LogLogin::create([
                'ip' => \request()->ip(),
                'user_agent' => \request()->userAgent(),
                'username' => \request('username') ?? \request()->user()->get('username'),
                'success' => $success,
                'operation' => $operation,
                'error' => $error,
            ]);

            if (!$login) return false;

            return true;
        } catch (Exception $e) {
            return errorResponse(500, (array)$e->getMessage());
        }
    }

}



