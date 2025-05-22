<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ProfileController extends Controller
{
    protected $adminService;
     function __construct(AdminService $adminService)
     {
        return $this->adminService = $adminService;
     }

    public function my(){
        try {
            $adminProfile  = $this->adminService->profile();

            return $adminProfile['status'] ? ResponseBuilder::asSuccess($adminProfile['code'])
            ->withHttpCode($adminProfile['code'])
            ->withMessage($adminProfile['message'])
            ->withData($adminProfile['data'])
            ->build()
            : ResponseBuilder::asError($adminProfile['code'])
            ->withHttpCode($adminProfile['code'])
            ->withMessage($adminProfile['message'])
            ->withData($adminProfile['data'])
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
