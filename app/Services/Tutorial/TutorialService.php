<?php

namespace App\Services\Tutorial;

use LaravelEasyRepository\BaseService;

interface TutorialService extends BaseService{

    // Write something awesome :)
    public function getAllTutorial($request);
    public function showTutorial(string $slug);
    public function storeTutorial($request);
    public function updateTutorial($request);
    public function deleteTutorial(int $id);

}
