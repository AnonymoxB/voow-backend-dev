<?php

namespace App\Repositories\InvitationRsvp;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\InvitationRsvp;

class InvitationRsvpRepositoryImplement extends Eloquent implements InvitationRsvpRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(InvitationRsvp $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function whereFirst($where,$with = array()){
        return $this->model->with($with)->where($where)->first();
    }
    public function whereGet($where,$with = array()){
        return $this->model->with($with)->where($where)->get();
    }

    public function whereRelationGet($where = array(),$relation,$whereRelation = array()){
        return $this->model->where($where)->whereHas($relation, function ($query) use($whereRelation) {
            return $query->where($whereRelation);
        })->get();
    }
}
