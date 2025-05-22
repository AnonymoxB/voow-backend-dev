<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository{

    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

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
