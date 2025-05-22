<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\LoginRequest;
use LaravelEasyRepository\BaseService;

interface AdminService extends BaseService{

    // Write something awesome :)
    public function login(LoginRequest $request);
    public function profile();

}
