<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\JsonResponse
     */


    public function handle(Request $request, Closure $next)
    {
        $token = JWTAuth::getToken();
        if (!$token) {
            $response = ['status' => 401, 'message' => 'Required field token is missing or empty.'];
            return $this->returnResponse($response);
        }
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                $response = ['status' => 401, 'message' => 'User not found.'];
                return $this->returnResponse($response);
            }

            if ($user->status == 0) {
                $response = ['status' => 402, 'message' => 'Your account is deactivated. Please contact the administrator.'];
                return $this->returnResponse($response);
            }

        } catch (Exception $e) {
            $user_session_table = DB::table('users_sessions')->where(['token' => $token, 'status' => 0]);
            if ($user_session_table->exists()) {
                // $user_session_table->delete();
                $response = ['status' => 410, 'message' => 'Your account is logged in into new device.'];
            } else {
                $user_session_table->delete();
                $response = ['status' => 401, 'message' => 'Invalid token.'];
            }
            return $this->returnResponse($response);

        }
        return $next($request);
    }

    public function returnResponse($response)
    {
        try {
            if (str_contains(request()->url(), 'AlyRcsy')) {
                return response()->json(encrypt_response(config('constants.ENCRYPT_DECRYPT_KEY_NEW'), config('constants.ENCRYPT_DECRYPT_IV_NEW'), json_encode($response)));
            } else {
                return response()->json($response);
            }
        } catch (Exception $e) {
            Log::error('JWTMiddleware.php : returnResponse : Exception.', ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return response()->json(['status' => 400, 'message' => 'Something went wrong. Please try after sometime.']);
        }
    }

}
