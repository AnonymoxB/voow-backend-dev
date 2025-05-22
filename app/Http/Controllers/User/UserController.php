<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class UserController extends Controller
{
    protected $userService;

    function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function listUser(){
        try {
            $userData =  $this->userService->getAllUser();

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get User Data Succesfully")
                ->withData($userData)
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
