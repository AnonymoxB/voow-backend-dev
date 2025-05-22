<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Services\Blog\BlogService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class BlogController extends Controller
{
    protected $blogService;
    function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function frontIndex(Request $request)
    {
        try {
            $request['status'] = "Publish";
            $blogData =  $this->blogService->getAllBlog($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Blog Data Succesfully")
                ->withData($blogData)
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

            $blogData =  $this->blogService->showBlog($slug);

            return $blogData ?

                ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Blog Data Succesfully")
                ->withData($blogData)
                ->build()
                :
                ResponseBuilder::asError(404)
                ->withHttpCode(404)
                ->withMessage("Blog Not Found")
                ->withData($blogData)
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage($th->getMessage())
                ->build();
        }
    }

    public function adminIndex(Request $request)
    {
        try {
            $blogData =  $this->blogService->getAllBlog($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Blog Data Succesfully")
                ->withData($blogData)
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

            $blogData =  $this->blogService->showBlog($slug);

            return $blogData ?

                ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Blog Data Succesfully")
                ->withData($blogData)
                ->build()
                :
                ResponseBuilder::asError(404)
                ->withHttpCode(404)
                ->withMessage("Blog Not Found")
                ->withData($blogData)
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage($th->getMessage())
                ->build();
        }
    }

    public function adminStore(BlogCreateRequest $request){
        try {

            $blogData = $this->blogService->storeBlog($request);

            return $blogData['status'] ? ResponseBuilder::asSuccess($blogData['code'])
            ->withHttpCode($blogData['code'])
            ->withMessage($blogData['message'])
            ->withData($blogData['data'])
            ->build()
            : ResponseBuilder::asError($blogData['code'])
            ->withHttpCode($blogData['code'])
            ->withMessage($blogData['message'])
            ->withData($blogData['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function adminUpdate(BlogUpdateRequest $request){
        try {

            $blogData = $this->blogService->updateBlog($request);

            return $blogData['status'] ? ResponseBuilder::asSuccess($blogData['code'])
            ->withHttpCode($blogData['code'])
            ->withMessage($blogData['message'])
            ->withData($blogData['data'])
            ->build()
            : ResponseBuilder::asError($blogData['code'])
            ->withHttpCode($blogData['code'])
            ->withMessage($blogData['message'])
            ->withData($blogData['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function adminDelete(Request $request){
        try {

            $deleteBlog = $this->blogService->deleteBlog($request->id);

            return $deleteBlog['status'] ? ResponseBuilder::asSuccess($deleteBlog['code'])
            ->withHttpCode($deleteBlog['code'])
            ->withMessage($deleteBlog['message'])
            ->withData($deleteBlog['data'])
            ->build()
            : ResponseBuilder::asError($deleteBlog['code'])
            ->withHttpCode($deleteBlog['code'])
            ->withMessage($deleteBlog['message'])
            ->withData($deleteBlog['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }
}
