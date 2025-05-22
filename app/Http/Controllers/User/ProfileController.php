<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ProfileController extends Controller
{
    protected $userService;

    function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile(){
        try {
            $profile =  $this->userService->profile();

            return $profile['status'] ? ResponseBuilder::asSuccess($profile['code'])
            ->withHttpCode($profile['code'])
            ->withMessage($profile['message'])
            ->withData($profile['data'])
            ->build()
            : ResponseBuilder::asError($profile['code'])
            ->withHttpCode($profile['code'])
            ->withMessage($profile['message'])
            ->withData($profile['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function updateProfile(UpdateProfileRequest $request){
        try {
            $profile =  $this->userService->updateProfile($request);

            return $profile['status'] ? ResponseBuilder::asSuccess($profile['code'])
            ->withHttpCode($profile['code'])
            ->withMessage($profile['message'])
            ->withData($profile['data'])
            ->build()
            : ResponseBuilder::asError($profile['code'])
            ->withHttpCode($profile['code'])
            ->withMessage($profile['message'])
            ->withData($profile['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }
    public function updatePassword(UpdatePasswordRequest $request){
        try {
            $profile =  $this->userService->updatePassword($request);

            return $profile['status'] ? ResponseBuilder::asSuccess($profile['code'])
            ->withHttpCode($profile['code'])
            ->withMessage($profile['message'])
            ->withData($profile['data'])
            ->build()
            : ResponseBuilder::asError($profile['code'])
            ->withHttpCode($profile['code'])
            ->withMessage($profile['message'])
            ->withData($profile['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }
}
