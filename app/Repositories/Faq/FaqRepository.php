<?php

namespace App\Repositories\Faq;

use LaravelEasyRepository\Repository;

interface FaqRepository extends Repository{

    // Write something awesome :)
    public function getAllData($where = array(), $limit, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array());

}
