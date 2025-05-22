<?php

namespace App\Services\Blog;

use LaravelEasyRepository\BaseService;

interface BlogService extends BaseService{
    public function getAllBlog($request);
    public function showBlog($slug);
    public function storeBlog($request);
    public function deleteBlog(int $id);
    public function updateBlog($request);
}

