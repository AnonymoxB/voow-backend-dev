<?php

namespace App\Repositories\Invitation;

use LaravelEasyRepository\Repository;

interface InvitationRepository extends Repository{

    public function getAllData($where = array(), $limit, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array());
    public function whereFirst($where,$with = array());
    public function whereGet($where,$with = array());
    public function findWith($id,$with = array(),$where = array());
}
