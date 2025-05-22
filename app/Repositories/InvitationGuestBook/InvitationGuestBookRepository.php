<?php

namespace App\Repositories\InvitationGuestBook;

use LaravelEasyRepository\Repository;

interface InvitationGuestBookRepository extends Repository{

    // Write something awesome :)
    public function getAllData($where = array(), $limit = 10, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array());
    public function searchData($where = array(), $limit = 10, $offset = 1, $sort_column ="id", $sort_order = "ASC", $search_column = "", $keyword = "",$with = array());
    public function whereFirst($where,$with = array());
    public function whereGet($where,$with = array());
    public function whereSelectGet($select,$where,$with = array());
    public function whereRelationGet($where = array(),$relation,$whereRelation = array());
}
