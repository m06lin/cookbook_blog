<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthUserService;

class AuthUserController extends Controller
{
    private $service;
    public function __construct(AuthUserService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        if (!$token = \Auth::guard('web')->attempt($credentials)) {
            return $this->toJsonResponse(401, null, 'Unauthorized', 'login fail');
        }

        return $this->toJsonResponse(200, $this->respondWithToken($token), 'success');
    }

    public function logout(Request $request)
    {
        \Auth::guard('web')->logout();

        return $this->toJsonResponse(200, null, 'success');
    }

    public function userProfile(Request $request)
    {
        $user = \Auth::guard('web')->user();
        if ($user) {
            return $this->toJsonResponse(200, $user, 'success');
        }
        return $this->toJsonResponse(401, null, 'fail', 'Unauthorized');
    }

    public function receiptList(Request $request)
    {
        $result = $this->service->recipeList();
        return $this->toJsonResponse(200, $result, 'success');
    }

    private function respondWithToken($token)
    {
        return [
            'token_type' => 'bearer',
            'token' => $token,
            'expires_in' => \Auth::guard('web')->factory()->getTTL() * 60
        ];
    }
}
