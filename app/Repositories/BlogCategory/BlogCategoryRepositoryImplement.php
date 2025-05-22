<?php

namespace App\Repositories\BlogCategory;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\BlogCategory;

class BlogCategoryRepositoryImplement extends Eloquent implements BlogCategoryRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(BlogCategory $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function getAllData($where = array(), $limit = 10, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array())
    {
        return $this->model->with($with)->where($where)->offset($offset)->limit($limit)->orderBy($sort_column, $sort_order)->get();
    }

    public function searchData($where = array(), $limit = 10, $offset = 1, $sort_column ="id", $sort_order = "ASC", $search_column = "", $keyword = "",$with = array())
    {
        return $this->model->with($with)->where($where)->offset($offset)->limit($limit)->whereRaw("LOWER($search_column) like '%" . $keyword . "%'")->orderBy($sort_column, $sort_order)->get();
    }

    public function whereFirst($where,$with = array()){
        return $this->model->with($with)->where($where)->first();
    }


}
