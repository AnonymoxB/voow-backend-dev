<?php

namespace App\Repositories\Invitation;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Invitation;

class InvitationRepositoryImplement extends Eloquent implements InvitationRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Invitation $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function getAllData($where = array(), $limit, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array()){
        if($limit != 0 || $offset != 0){
            return $this->model->with($with)->where($where)->offset($offset)->limit($limit)->orderBy($sort_column, $sort_order)->get();
        }
       return $this->model->with($with)->where($where)->orderBy($sort_column, $sort_order)->get();

    }

    public function whereFirst($where,$with = array()){
        return $this->model->with($with)->where($where)->first();
    }

    public function whereGet($where,$with = array()){
        return $this->model->with($with)->where($where)->get();
    }

    public function findWith($id,$with = array(),$where = array()){
        return $this->model->where($where)->with($with)->find($id);
    }

}
