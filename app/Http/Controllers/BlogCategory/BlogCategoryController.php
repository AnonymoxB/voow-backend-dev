<?php

namespace App\Http\Controllers\BlogCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategoryCreateRequest;
use App\Http\Requests\Admin\BlogCategoryUpdateRequest;
use App\Services\BlogCategory\BlogCategoryService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class BlogCategoryController extends Controller
{

    protected $blogCategoryService;

    function __construct(BlogCategoryService $blogCategoryService)
    {
        $this->blogCategoryService = $blogCategoryService;
    }


    public function frontIndex(Request $request){
        try {
            $blogCategory =  $this->blogCategoryService->getAllBlogCategory($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Blog Category Data Succesfully")
                ->withData($blogCategory)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function frontShow($slug)
    {
        try {

            $blogCategoryData =  $this->blogCategoryService->showBlogCategory($slug);

            return $blogCategoryData ?
                ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Blog Category Data Succesfully")
                ->withData($blogCategoryData)
                ->build()
                :
                ResponseBuilder::asError(404)
                ->withHttpCode(404)
                ->withMessage("Blog Category Not Found")
                ->withData($blogCategoryData)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage($th->getMessage())
                ->build();
        }
    }


    //admin

    public function adminIndex(Request $request){
        try {
            $blogCategory =  $this->blogCategoryService->getAllBlogCategory($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Blog Category Data Succesfully")
                ->withData($blogCategory)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function adminShow($slug)
    {
        try {

            $blogCategoryData =  $this->blogCategoryService->showBlogCategory($slug);

            return $blogCategoryData ?
                ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Blog Category Data Succesfully")
                ->withData($blogCategoryData)
                ->build()
                :
                ResponseBuilder::asError(404)
                ->withHttpCode(404)
                ->withMessage("Blog Category Not Found")
                ->withData($blogCategoryData)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage($th->getMessage())
                ->build();
        }
    }

    public function store(BlogCategoryCreateRequest $request){
        try {

           $blogCategoryCreate = $this->blogCategoryService->storeBlogCategory($request);

            return $blogCategoryCreate['status'] ? ResponseBuilder::asSuccess($blogCategoryCreate['code'])
            ->withHttpCode($blogCategoryCreate['code'])
            ->withMessage($blogCategoryCreate['message'])
            ->withData($blogCategoryCreate['data'])
            ->build()
            : ResponseBuilder::asError($blogCategoryCreate['code'])
            ->withHttpCode($blogCategoryCreate['code'])
            ->withMessage($blogCategoryCreate['message'])
            ->withData($blogCategoryCreate['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage($th->getMessage())
            ->build();
        }
    }

    public function update(BlogCategoryUpdateRequest $request){
        try {
            $blogCategoryUpdate = $this->blogCategoryService->updateBlogCategory($request);

            return $blogCategoryUpdate['status'] ? ResponseBuilder::asSuccess($blogCategoryUpdate['code'])
            ->withHttpCode($blogCategoryUpdate['code'])
            ->withMessage($blogCategoryUpdate['message'])
            ->withData($blogCategoryUpdate['data'])
            ->build()
            : ResponseBuilder::asError($blogCategoryUpdate['code'])
            ->withHttpCode($blogCategoryUpdate['code'])
            ->withMessage($blogCategoryUpdate['message'])
            ->withData($blogCategoryUpdate['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage($th->getMessage())
            ->build();
        }
    }

    public function delete(Request $request){
        try {
            $blogCategoryDelete = $this->blogCategoryService->deleteBlogCategory($request);

            return $blogCategoryDelete['status'] ? ResponseBuilder::asSuccess($blogCategoryDelete['code'])
            ->withHttpCode($blogCategoryDelete['code'])
            ->withMessage($blogCategoryDelete['message'])
            ->withData($blogCategoryDelete['data'])
            ->build()
            : ResponseBuilder::asError($blogCategoryDelete['code'])
            ->withHttpCode($blogCategoryDelete['code'])
            ->withMessage($blogCategoryDelete['message'])
            ->withData($blogCategoryDelete['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage($th->getMessage())
            ->build();
        }
    }


}
