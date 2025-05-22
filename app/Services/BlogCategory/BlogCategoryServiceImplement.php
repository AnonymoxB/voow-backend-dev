<?php

namespace App\Services\BlogCategory;

use LaravelEasyRepository\Service;
use App\Repositories\BlogCategory\BlogCategoryRepository;
use Exception;
use Illuminate\Support\Str;

class BlogCategoryServiceImplement extends Service implements BlogCategoryService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(BlogCategoryRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getAllBlogCategory($request){
        try {

            $limit = $request->limit ?? 10;
            $sort_column = $request->sort_column ?? "id";
            $sort_order = $request->sort_order ?? "ASC";
            $offset = $request->offset ?? 0;
            $with = [];
            $where = [];

            if ($request->has('search')) {
                $search = $request->search;
                $blogCategoryData = $this->mainRepository->searchData($where, $limit, $offset, $sort_column, $sort_order, 'title', $search, $with);
            } else {
                $blogCategoryData =  $this->mainRepository->getAllData($where, $limit, $offset, $sort_column, $sort_order, $with);
            }

            return $blogCategoryData;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function showBlogCategory($slug){
        try {
            $where = [['slug', $slug]];
            $blogData = $this->mainRepository->whereFirst($where, ['blogs']);
            return $blogData;

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function storeBlogCategory($request){
        try {

            $blogCategoryCreate = $this->mainRepository->create([
                'title' => $request->title,
                'slug' => Str::slug($request->title.Str::random(4)),
                'description' => $request->description,
                'lang' => $request->lang,
                'parent_id' => $request->parent_id
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['blog_category' => $blogCategoryCreate],
                'message' => 'Success Create Blog Category'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateBlogCategory($request){
        try {
            $blogCategoryUpdate = $this->mainRepository->find($request->id);

            if(!$blogCategoryUpdate){
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => ['blog_category' => null],
                    'message' => 'Blog Category Not Found'
                ];
            }

            $blogCategoryUpdate->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'lang' => $request->lang,
                'parent_id' => $request->parent_id
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['blog_category' => $blogCategoryUpdate],
                'message' => 'Success Update Blog Category'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function deleteBlogCategory($request){
        try {
            $blogCategoryDelete = $this->mainRepository->find($request->id);

            if(!$blogCategoryDelete){
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => ['blog_category' => null],
                    'message' => 'Blog Category Not Found'
                ];
            }

            $blogCategoryDelete->delete($request->id);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['blog_category' => $blogCategoryDelete],
                'message' => 'Success Delete Blog Category'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

}
