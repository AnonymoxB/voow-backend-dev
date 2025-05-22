<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class DashboardController extends Controller
{
    protected $dashboardService;

    function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function getAllCountData(){
        try {
            $adminProfile  = $this->dashboardService->coundDataDashboard();

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
