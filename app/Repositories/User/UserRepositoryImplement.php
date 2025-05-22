<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository{

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

    public function getUserByEmail(string $email){
        return $this->model->select('email')->whereHasRole(['user'])->where('email',$email)->first();
    }

    public function getUserByPhoneNumber(string $phone_number){
        return $this->model->select('phone_number')->whereHasRole(['user'])->where('phone_number',$phone_number)->first();
    }

    public function getAllUserData($where = array(), $limit = 0, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array())
    {
        if($limit != 0 || $offset != 0){
            return $this->model->with($with)->whereHasRole('user')->where($where)->offset($offset)->limit($limit)->orderBy($sort_column, $sort_order)->get();
        }else{
            return $this->model->with($with)->whereHasRole('user')->where($where)->orderBy($sort_column, $sort_order)->get();
        }
    }

    public function count(){
        $data =  $this->model->get();
        return $data->count();
    }

    public function findWith(int $id,array $with){
        return $this->model->with($with)->find($id);
    }


}
