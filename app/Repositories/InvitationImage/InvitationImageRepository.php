<?php

namespace App\Repositories\InvitationImage;

use LaravelEasyRepository\Repository;

interface InvitationImageRepository extends Repository{

    // Write something awesome :)
    public function getWhere($where = array());
    public function findWhere($where = array());
}
