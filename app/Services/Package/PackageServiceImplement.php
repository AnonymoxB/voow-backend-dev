<?php

namespace App\Services\Package;

use LaravelEasyRepository\Service;
use App\Repositories\Package\PackageRepository;
use Exception;

class PackageServiceImplement extends Service implements PackageService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(PackageRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getAllPackage(){
        try {

            $packageData =  $this->mainRepository->all();
            return $packageData;

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
