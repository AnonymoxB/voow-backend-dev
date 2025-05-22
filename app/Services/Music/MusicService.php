<?php

namespace App\Services\Music;

use LaravelEasyRepository\BaseService;

interface MusicService extends BaseService{

    // Write something awesome :)
    public function get($request);
    public function store($request);
}
