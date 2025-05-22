<?php

namespace App\Services\TemplateCategory;

use LaravelEasyRepository\BaseService;

interface TemplateCategoryService extends BaseService{

    // Write something awesome :)
    public function getAllTemplateCategory($request);
    public function showTemplateCategory($slug);
}
