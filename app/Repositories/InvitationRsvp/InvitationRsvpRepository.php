<?php

namespace App\Repositories\InvitationRsvp;

use LaravelEasyRepository\Repository;

interface InvitationRsvpRepository extends Repository{

    // Write something awesome :)
    public function whereFirst($where,$with = array());
    public function whereGet($where,$with = array());
    public function whereRelationGet($where = array(),$relation,$whereRelation = array());
}
