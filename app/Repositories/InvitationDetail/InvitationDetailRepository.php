<?php

namespace App\Repositories\InvitationDetail;

use LaravelEasyRepository\Repository;

interface InvitationDetailRepository extends Repository{

    // Write something awesome :)

    public function whereFirst($where,$with = array());
}
