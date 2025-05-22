<?php

namespace App\Repositories\Admin;

use LaravelEasyRepository\Repository;

interface AdminRepository extends Repository{

    // Write something awesome :)
    public function getAdminByEmail(string $email);
}
