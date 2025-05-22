<?php

namespace App\Services\TutorialCategory;

use LaravelEasyRepository\Service;
use App\Repositories\TutorialCategory\TutorialCategoryRepository;
use Exception;
use Illuminate\Support\Str;

class TutorialCategoryServiceImplement extends Service implements TutorialCategoryService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(TutorialCategoryRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getAllTutorialCategory($request)
    {
        try {

            $limit = $request->limit ?? 10;
            $sort_column = $request->sort_column ?? "id";
            $sort_order = $request->sort_order ?? "ASC";
            $offset = $request->offset ?? 0;
            $with = [];
            $where = [];

            if ($request->has('search')) {
                $search = $request->search;
                $tutorialCategory = $this->mainRepository->searchData($where, $limit, $offset, $sort_column, $sort_order, 'title', $search, $with);
            } else {
                $tutorialCategory =  $this->mainRepository->getAllData($where, $limit, $offset, $sort_column, $sort_order, $with);
            }

            return $tutorialCategory;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function showTutorialCategory($slug)
    {
        try {
            $where = [['slug', $slug]];
            $tutorialCategory = $this->mainRepository->whereFirst($where, ['tutorials']);
            return $tutorialCategory;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function storeTutorialCategory($request)
    {
        try {

            $tutorialCategoryCreate = $this->mainRepository->create([
                'title' => $request->title,
                'slug' => Str::slug($request->title.Str::random(4)),
                'description' => $request->description,
                'lang' => $request->lang,
                'parent_id' => $request->parent_id
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['tutorial_category' => $tutorialCategoryCreate],
                'message' => 'Success Create Tutorial Category'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateTutorialCategory($request){
        try {

            $tutorialCategoryUpdate = $this->mainRepository->find($request->id);

            if(!$tutorialCategoryUpdate){
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => ['tutorial_category' => null],
                    'message' => 'Tutorial Category Not Found'
                ];
            }

            $tutorialCategoryUpdate->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'lang' => $request->lang,
                'parent_id' => $request->parent_id
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['tutorial_category' => $tutorialCategoryUpdate],
                'message' => 'Success Update Tutorial Category'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function deleteTutorialCategory($request){
        try {
            $tutorialCategoryDelete = $this->mainRepository->find($request->id);

            if(!$tutorialCategoryDelete){
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => ['tutorial_category' => null],
                    'message' => 'Tutorial Category Not Found'
                ];
            }

            $tutorialCategoryDelete->delete();


            return [
                'code' => 200,
                'status' => true,
                'data' => ['tutorial_category' => $tutorialCategoryDelete],
                'message' => 'Success Delete Tutorial Category'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
