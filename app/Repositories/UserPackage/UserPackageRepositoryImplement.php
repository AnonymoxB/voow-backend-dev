<?php

namespace App\Repositories\UserPackage;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\UserPackage;

class UserPackageRepositoryImplement extends Eloquent implements UserPackageRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(UserPackage $model)
    {
        $this->model = $model;
    }

    public function checkUserIsPremium(int $userId)
    {
        $userPackage =  $this->model->where('user_id',$userId)->first();
        return $userPackage;
    }
}
