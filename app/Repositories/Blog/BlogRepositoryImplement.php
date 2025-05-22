<?php

namespace App\Repositories\Blog;


use App\Models\Blog;
use LaravelEasyRepository\Implementations\Eloquent;

class BlogRepositoryImplement extends Eloquent implements BlogRepository {

    protected $model;

    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

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
        return $this->model->with($with)->where($where)->offset($offset)->limit($limit)->whereRaw("LOWER($search_column) like '%" . $keyword . "%'")->orderBy($sort_column, $sort_order)->get();
    }

    public function whereFirst($where,$with = array()){
        return $this->model->with($with)->where($where)->first();
    }

}
