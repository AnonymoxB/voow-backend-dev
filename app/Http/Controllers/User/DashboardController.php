<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\DashboardUser\DashboardUserService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class DashboardController extends Controller
{
    function __construct(private DashboardUserService $dashboardUserService)
    {
        $this->dashboardUserService = $dashboardUserService;
    }

    public function getCountDashboard(){
        try {
            $dashboardUserCountData = $this->dashboardUserService->countDataDashboardUser();;

            return $dashboardUserCountData['status'] ? ResponseBuilder::asSuccess($dashboardUserCountData['code'])
                ->withHttpCode($dashboardUserCountData['code'])
                ->withMessage($dashboardUserCountData['message'])
                ->withData($dashboardUserCountData['data'])
                ->build()
                : ResponseBuilder::asError($dashboardUserCountData['code'])
                ->withHttpCode($dashboardUserCountData['code'])
                ->withMessage($dashboardUserCountData['message'])
                ->withData($dashboardUserCountData['data'])
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
