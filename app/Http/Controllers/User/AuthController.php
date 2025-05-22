<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Services\User\UserService;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class AuthController extends Controller
{
    protected $userService;

    function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $register =  $this->userService->register($request);

            return $register['status'] ? ResponseBuilder::asSuccess($register['code'])
                ->withHttpCode($register['code'])
                ->withMessage($register['message'])
                ->withData($register['data'])
                ->build()
                : ResponseBuilder::asError($register['code'])
                ->withHttpCode($register['code'])
                ->withMessage($register['message'])
                ->withData($register['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function login(LoginRequest $request)
    {
        try {

            $login =  $this->userService->login($request);

            return $login['status'] ? ResponseBuilder::asSuccess($login['code'])
                ->withHttpCode($login['code'])
                ->withMessage($login['message'])
                ->withData($login['data'])
                ->build()
                : ResponseBuilder::asError($login['code'])
                ->withHttpCode($login['code'])
                ->withMessage($login['message'])
                ->withData($login['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function socialLogin($provider)
    {
        try {
            $socialLogin =  $this->userService->socialLogin($provider);

            return $socialLogin;

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function socialLoginCallback($provider)
    {
        try {

            $handleCallbackLogin =  $this->userService->handleCallbackSocialLogin($provider);

            return $handleCallbackLogin;

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage('Logout successfully')
                ->build();
        } catch (\Exception $e) {
            return ResponseBuilder::asError(500)
                ->withData($e->getMessage())
                ->withHttpCode(500)
                ->withMessage('Something Error')
                ->build();
        }
    }
}
