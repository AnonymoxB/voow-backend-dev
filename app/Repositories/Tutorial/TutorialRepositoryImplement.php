<?php

namespace App\Repositories\Tutorial;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Tutorial;

class TutorialRepositoryImplement extends Eloquent implements TutorialRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */

    protected $model;

    public function __construct(Tutorial $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function getAllData($where = array(), $limit = 0, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array())
    {
        if($limit != 0 || $offset != 0){
            return $this->model->with($with)->where($where)->offset($offset)->limit($limit)->orderBy($sort_column, $sort_order)->get();
        }else{
            return $this->model->with($with)->where($where)->orderBy($sort_column, $sort_order)->get();
        }

    }

    public function searchData($where = array(), $limit = 10, $offset = 1, $sort_column ="id", $sort_order = "ASC", $search_column = "", $keyword = "",$with = array())
    {
        return $this->model->with($with)->where($where)->whereRaw("LOWER($search_column) like '%" . $keyword . "%'")->orderBy($sort_column, $sort_order)->get();
    }

    public function whereFirst($where,$with = array()){
        return $this->model->with($with)->where($where)->first();
    }

}
