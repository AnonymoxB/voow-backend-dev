<?php

namespace App\Repositories\Package;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Package;

class PackageRepositoryImplement extends Eloquent implements PackageRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Package $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
