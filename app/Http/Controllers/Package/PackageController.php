<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Services\Package\PackageService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class PackageController extends Controller
{
    protected $packageService;
    function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }

    public function frontIndex(){
        try {
            $packageData =  $this->packageService->getAllPackage();

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Package Data Succesfully")
                ->withData($packageData)
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
