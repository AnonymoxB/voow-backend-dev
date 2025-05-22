<?php

namespace App\Repositories\Transaction;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Transaction;

class TransactionRepositoryImplement extends Eloquent implements TransactionRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Transaction $model)
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

    public function findPendingTransactionByUser($userId){
        return $this->model->where('user_id',$userId)->where('status','Pending')->first();
    }

    public function getTransactionByUser($userId){
        return $this->model->where('user_id',$userId)->with('package','user')->get();
    }

    public function getTransactionByInvoice($invoice){
        return $this->model->where('invoice',$invoice)->where('status','Pending')->first();

    }
}
