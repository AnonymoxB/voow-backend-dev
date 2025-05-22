<?php

namespace App\Services\User;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    // Write something awesome :)
    public function login(LoginRequest $request);
    public function register(RegisterRequest $request);
    public function profile();
    public function socialLogin($provider);
    public function handleCallbackSocialLogin($provider);
    public function updatePassword(UpdatePasswordRequest $request);
    public function getAllUser();
    public function updateProfile($request);
}
