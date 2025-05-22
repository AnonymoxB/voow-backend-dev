<?php

namespace App\Repositories\InvitationDetail;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\InvitationDetail;

class InvitationDetailRepositoryImplement extends Eloquent implements InvitationDetailRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(InvitationDetail $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function whereFirst($where,$with = array()){
        return $this->model->with($with)->where($where)->first();
    }

}
