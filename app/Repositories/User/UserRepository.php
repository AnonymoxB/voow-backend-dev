<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository{

    // Write something awesome :)
    public function getUserByEmail(string $email);
    public function getUserByPhoneNumber(string $phone_number);
    public function getAllUserData($where = array(), $limit = 0, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array());
    public function findWith(int $id,array $with);
}
