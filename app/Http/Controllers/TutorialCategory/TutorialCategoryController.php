<?php

namespace App\Http\Controllers\TutorialCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TutorialCategoryCreateRequest;
use App\Http\Requests\Admin\TutorialCategoryUpdateRequest;
use App\Services\TutorialCategory\TutorialCategoryService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class TutorialCategoryController extends Controller
{
    protected $tutorialCategoryService;

    function __construct(TutorialCategoryService $tutorialCategoryService)
    {
        $this->tutorialCategoryService = $tutorialCategoryService;
    }

    public function frontIndex(Request $request){
        try {
            $tutorialCategory =  $this->tutorialCategoryService->getAllTutorialCategory($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Tutorial Category Data Succesfully")
                ->withData($tutorialCategory)
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

            $tutorialDataShow =  $this->tutorialCategoryService->showTutorialCategory($slug);

            return $tutorialDataShow ?
                ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Tutorial Category Data Succesfully")
                ->withData($tutorialDataShow)
                ->build()
                :
                ResponseBuilder::asError(404)
                ->withHttpCode(404)
                ->withMessage("Tutorial Category Not Found")
                ->withData($tutorialDataShow)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage($th->getMessage())
                ->build();
        }
    }


    public function adminIndex(Request $request){
        try {
            $tutorialCategory =  $this->tutorialCategoryService->getAllTutorialCategory($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Tutorial Category Data Succesfully")
                ->withData($tutorialCategory)
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

            $tutorialDataShow =  $this->tutorialCategoryService->showTutorialCategory($slug);

            return $tutorialDataShow ?
                ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Tutorial Category Data Succesfully")
                ->withData($tutorialDataShow)
                ->build()
                :
                ResponseBuilder::asError(404)
                ->withHttpCode(404)
                ->withMessage("Tutorial Category Not Found")
                ->withData($tutorialDataShow)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage($th->getMessage())
                ->build();
        }
    }


    public function store(TutorialCategoryCreateRequest $request){
        try {
            $tutorialCategoryCreate = $this->tutorialCategoryService->storeTutorialCategory($request);

            return $tutorialCategoryCreate['status'] ? ResponseBuilder::asSuccess($tutorialCategoryCreate['code'])
            ->withHttpCode($tutorialCategoryCreate['code'])
            ->withMessage($tutorialCategoryCreate['message'])
            ->withData($tutorialCategoryCreate['data'])
            ->build()
            : ResponseBuilder::asError($tutorialCategoryCreate['code'])
            ->withHttpCode($tutorialCategoryCreate['code'])
            ->withMessage($tutorialCategoryCreate['message'])
            ->withData($tutorialCategoryCreate['data'])
            ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage($th->getMessage())
            ->build();
        }
    }

    public function update(TutorialCategoryUpdateRequest $request){
        try {
            $tutorialCategoryUpdate = $this->tutorialCategoryService->updateTutorialCategory($request);

            return $tutorialCategoryUpdate['status'] ? ResponseBuilder::asSuccess($tutorialCategoryUpdate['code'])
            ->withHttpCode($tutorialCategoryUpdate['code'])
            ->withMessage($tutorialCategoryUpdate['message'])
            ->withData($tutorialCategoryUpdate['data'])
            ->build()
            : ResponseBuilder::asError($tutorialCategoryUpdate['code'])
            ->withHttpCode($tutorialCategoryUpdate['code'])
            ->withMessage($tutorialCategoryUpdate['message'])
            ->withData($tutorialCategoryUpdate['data'])
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

            $tutorialCategoryDelete = $this->tutorialCategoryService->deleteTutorialCategory($request);

            return $tutorialCategoryDelete['status'] ? ResponseBuilder::asSuccess($tutorialCategoryDelete['code'])
            ->withHttpCode($tutorialCategoryDelete['code'])
            ->withMessage($tutorialCategoryDelete['message'])
            ->withData($tutorialCategoryDelete['data'])
            ->build()
            : ResponseBuilder::asError($tutorialCategoryDelete['code'])
            ->withHttpCode($tutorialCategoryDelete['code'])
            ->withMessage($tutorialCategoryDelete['message'])
            ->withData($tutorialCategoryDelete['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage($th->getMessage())
            ->build();
        }
    }

}
