<?php

namespace App\Services\Blog;

use App\Repositories\Blog\BlogRepository;
use App\Services\Common\Upload\UploadService;
use Exception;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Service;
use Illuminate\Support\Str;

class BlogServiceImplement extends Service implements BlogService
{

    protected $blogRepository;
    protected $uploadService;

    function __construct(BlogRepository $blogRepository, UploadService $uploadService)
    {
        $this->blogRepository = $blogRepository;
        $this->uploadService = $uploadService;

    }

    public function getAllBlog($request)
    {
        try {

            $limit = $request->limit ?? 10;
            $sort_column = $request->sort_column ?? "id";
            $sort_order = $request->sort_order ?? "ASC";
            $offset = $request->offset ?? 0;
            $with = ['user', 'blogCategory'];
            $where = [];

            $request->status ? array_push($where, [
                ['status' => $request->status]
            ]) : [];

            if ($request->has('search')) {
                $search = $request->search;
                $blogData = $this->blogRepository->searchData($where, $limit, $offset, $sort_column, $sort_order, 'title', $search, $with);
            } else {
                $blogData =  $this->blogRepository->getAllData($where, $limit, $offset, $sort_column, $sort_order, $with);
            }

            return $blogData;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function showBlog($slug)
    {
        try {
            $where = [['slug', $slug]];
            $blogData = $this->blogRepository->whereFirst($where, ['user', 'blogCategory']);
            return $blogData;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function storeBlog($request)
    {
        try {
            $arrayInsert = [
                'user_id' => auth()->user()->id,
                'blog_category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => Str::slug($request->title . " " . Str::random(4)),
                'content' => $request->content,
                'status' => $request->status ?? "Draft",
                'lang' => $request->lang ?? "ID"
            ];

            if ($request->has('image')) {
                $uploadFile = $this->uploadService->uploadFileUsingCloudStorage('blog',$request->image);
                $arrayInsert['image'] = $uploadFile;
            }


            $blogInsert = $this->blogRepository->create($arrayInsert);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['tutorial' => $blogInsert],
                'message' => 'Success Create Blog'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateBlog($request)
    {
        try {

            $blog = $this->blogRepository->find($request->id);

            if(!$blog){
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => ['blog' => $request],
                    'message' => 'Blog Not Found'
                ];
            }

            $arrayInsert = [
                'user_id' => auth()->user()->id,
                'blog_category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => Str::slug($request->title . " " . Str::random(4)),
                'content' => $request->content,
                'status' => $request->status ?? "Draft",
                'lang' => $request->lang ?? "ID"
            ];

            if ($request->has('image') && $request->image != null) {
                if(!filter_var($blog->getRawOriginal('image'), FILTER_VALIDATE_URL)){
                    //check file, if exists and delete file from storage
                    $this->uploadService->deleteFileUseCloudStorage($blog->getRawOriginal('image'));
                }


                $filePath = $this->uploadService->uploadFileUsingCloudStorage('blog',$request->image);

                $arrayInsert['image'] = $filePath;
            }


            $this->blogRepository->update($request->id, $arrayInsert);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['blog' => $arrayInsert],
                'message' => 'Success Update blog'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function deleteBlog(int $id)
    {
        try {
            $findBlog = $this->blogRepository->find($id);

            if (!$findBlog) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => ['blog' => []],
                    'message' => 'Blog Not Found'
                ];
            }

            $filePath = $findBlog->getRawOriginal('image');

            if ($filePath){
                if(!filter_var($filePath, FILTER_VALIDATE_URL)){
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }elseif (Storage::disk('s3')->exists($filePath)) {
                        Storage::disk('s3')->delete($filePath);
                    }
                }

            }

            $findBlog->delete();

            return [
                'code' => 200,
                'status' => true,
                'data' => ['blog' => $findBlog],
                'message' => 'Success Delete Blog'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
