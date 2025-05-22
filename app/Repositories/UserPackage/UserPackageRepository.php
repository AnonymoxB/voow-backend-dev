<?php

namespace App\Repositories\UserPackage;

use LaravelEasyRepository\Repository;

interface UserPackageRepository extends Repository{

    // Write something awesome :)
    public function checkUserIsPremium(int $userId);
}
