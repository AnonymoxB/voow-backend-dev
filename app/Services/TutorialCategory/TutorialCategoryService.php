<?php

namespace App\Services\TutorialCategory;

use LaravelEasyRepository\BaseService;

interface TutorialCategoryService extends BaseService{

    // Write something awesome :)
    public function getAllTutorialCategory($request);
    public function showTutorialCategory($slug);
    public function storeTutorialCategory($request);
    public function updateTutorialCategory($request);
    public function deleteTutorialCategory($request);
}
