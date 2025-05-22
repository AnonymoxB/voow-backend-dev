<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AdminService;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class AuthController extends Controller
{
    protected $adminService;

    function __construct(AdminService $adminService)
    {
        return $this->adminService = $adminService;
    }

    public function login(LoginRequest $request)
    {
        try {

            $login =  $this->adminService->login($request);

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
