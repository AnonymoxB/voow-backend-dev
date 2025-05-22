<?php

namespace App\Repositories\Faq;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Faq;

class FaqRepositoryImplement extends Eloquent implements FaqRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Faq $model)
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

}
