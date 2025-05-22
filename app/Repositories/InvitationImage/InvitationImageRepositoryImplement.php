<?php

namespace App\Repositories\InvitationImage;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\InvitationImage;

class InvitationImageRepositoryImplement extends Eloquent implements InvitationImageRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(InvitationImage $model)
    {
        $this->model = $model;
    }

    public function getWhere($where = array()){
        return $this->model->where($where)->get();
    }


    public function findWhere($where = array()){
        return $this->model->where($where)->first();
    }

    // Write something awesome :)
}
