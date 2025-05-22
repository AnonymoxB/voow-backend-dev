<?php

namespace App\Services\Tutorial;

use LaravelEasyRepository\Service;
use App\Repositories\Tutorial\TutorialRepository;
use App\Services\Common\Upload\UploadService;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TutorialServiceImplement extends Service implements TutorialService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $uploadService;

    public function __construct(TutorialRepository $mainRepository, UploadService $uploadService)
    {
        $this->mainRepository = $mainRepository;
        $this->uploadService = $uploadService;
    }

    // Define your custom methods :)

    public function getAllTutorial($request)
    {
        try {

            $limit = $request->limit ?? 0;
            $sort_column = $request->sort_column ?? "id";
            $sort_order = $request->sort_order ?? "ASC";
            $offset = $request->offset ?? 0;
            $with = ['user', 'tutorialCategory'];
            $where = [];

            $request->status ? array_push($where, [
                ['status' => $request->status]
            ]) : [];


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

    public function showTutorial(string $slug)
    {
        try {
            $where = [['slug', $slug]];
            $tutorialData = $this->mainRepository->whereFirst($where, ['user', 'tutorialCategory']);
            return $tutorialData;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function storeTutorial($request)
    {
        try {


            $arrayInsert = [
                'user_id' => auth()->user()->id,
                'tutorial_category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => Str::slug($request->title . " " . Str::random(4)),
                'content' => $request->content,
                'link_youtube' => $request->link_youtube,
                'status' => $request->status ?? "Draft",
                'lang' => $request->lang ?? "ID"
            ];

            if ($request->has('image')) {
                $filePath = $this->uploadService->uploadImage($request->image, 'image', 'tutorial');
                $arrayInsert['image'] = url($filePath);
            }


            $tutorialInsert = $this->mainRepository->create($arrayInsert);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['tutorial' => $tutorialInsert],
                'message' => 'Success Create Tutorial'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


    public function updateTutorial($request)
    {
        try {

            $arrayInsert = [
                'user_id' => auth()->user()->id,
                'tutorial_category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => Str::slug($request->title . " " . Str::random(4)),
                'content' => $request->content,
                'link_youtube' => $request->link_youtube,
                'status' => $request->status ?? "Draft",
                'lang' => $request->lang ?? "ID"
            ];

            if ($request->has('image') && $request->image != null) {
                $filePath = $this->uploadService->uploadImage($request->image, 'image', 'tutorial');
                $arrayInsert['image'] = url($filePath);
            }


            $this->mainRepository->update($request->id, $arrayInsert);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['tutorial' => $request],
                'message' => 'Success Update Tutorial'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


    public function deleteTutorial(int $id)
    {
        try {
            $findTutorial = $this->mainRepository->find($id);

            if (!$findTutorial) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => ['tutorial' => []],
                    'message' => 'Tutorial Not Found'
                ];
            }


            $filePath = parse_url($findTutorial->image, PHP_URL_PATH);

            if ($filePath){
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            $findTutorial->delete();

            return [
                'code' => 200,
                'status' => true,
                'data' => ['tutorial' => $findTutorial],
                'message' => 'Success Delete Tutorial'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
