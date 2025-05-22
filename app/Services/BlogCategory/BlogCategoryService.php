<?php

namespace App\Services\BlogCategory;

use LaravelEasyRepository\BaseService;

interface BlogCategoryService extends BaseService{

    // Write something awesome :)
    public function getAllBlogCategory($request);
    public function showBlogCategory($slug);
    public function storeBlogCategory($request);
    public function updateBlogCategory($request);
    public function deleteBlogCategory($request);
}
