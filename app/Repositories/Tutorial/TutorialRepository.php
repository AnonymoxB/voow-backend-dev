<?php

namespace App\Repositories\Tutorial;

use LaravelEasyRepository\Repository;

interface TutorialRepository extends Repository{

    public function getAllData($where = array(), $limit = 10, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array());
    public function searchData($where = array(), $limit = 10, $offset = 1, $sort_column ="id", $sort_order = "ASC", $search_column = "", $keyword = "",$with = array());
    public function whereFirst($where,$with = array());

}
