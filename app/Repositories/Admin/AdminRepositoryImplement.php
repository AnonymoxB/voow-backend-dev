<?php

namespace App\Repositories\Admin;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class AdminRepositoryImplement extends Eloquent implements AdminRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function getAdminByEmail(string $email){
        return $this->model->select('email')->whereHasRole(['admin'])->where('email',$email)->first();
    }
}
