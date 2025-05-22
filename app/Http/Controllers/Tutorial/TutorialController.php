<?php

namespace App\Http\Controllers\Tutorial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TutorialRequest;
use App\Http\Requests\Admin\TutorialUpdateRequest;
use App\Services\Tutorial\TutorialService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class TutorialController extends Controller
{
    protected $tutorialService;

    function __construct(TutorialService $tutorialService)
    {
        $this->tutorialService = $tutorialService;
    }

    public function frontIndex(Request $request){
        try {

            $request['status'] = "Publish";
            $tutorialData =  $this->tutorialService->getAllTutorial($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Tutorial Data Succesfully")
                ->withData($tutorialData)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function frontShow(string $slug){
        try {

            $tutorialData = $this->tutorialService->showTutorial($slug);

            return ResponseBuilder::asSuccess(200)
            ->withHttpCode(200)
            ->withMessage("Get Tutorial Data Succesfully")
            ->withData($tutorialData)
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function adminIndex(Request $request){
        try {
            $tutorialData =  $this->tutorialService->getAllTutorial($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Tutorial Data Succesfully")
                ->withData($tutorialData)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function adminShow(string $slug){
        try {

            $tutorialData = $this->tutorialService->showTutorial($slug);

            return ResponseBuilder::asSuccess(200)
            ->withHttpCode(200)
            ->withMessage("Get Tutorial Data Succesfully")
            ->withData($tutorialData)
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function adminStore(TutorialRequest $request){
        try {

            $tutorialData = $this->tutorialService->storeTutorial($request);

            return $tutorialData['status'] ? ResponseBuilder::asSuccess($tutorialData['code'])
            ->withHttpCode($tutorialData['code'])
            ->withMessage($tutorialData['message'])
            ->withData($tutorialData['data'])
            ->build()
            : ResponseBuilder::asError($tutorialData['code'])
            ->withHttpCode($tutorialData['code'])
            ->withMessage($tutorialData['message'])
            ->withData($tutorialData['data'])
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function adminUpdate(TutorialUpdateRequest $request){
        try {

            $tutorialData = $this->tutorialService->updateTutorial($request);

            return $tutorialData['status'] ? ResponseBuilder::asSuccess($tutorialData['code'])
            ->withHttpCode($tutorialData['code'])
            ->withMessage($tutorialData['message'])
            ->withData($tutorialData['data'])
            ->build()
            : ResponseBuilder::asError($tutorialData['code'])
            ->withHttpCode($tutorialData['code'])
            ->withMessage($tutorialData['message'])
            ->withData($tutorialData['data'])
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

            return $deleteTutorial = $this->tutorialService->deleteTutorial($request->id);

            return $deleteTutorial['status'] ? ResponseBuilder::asSuccess($deleteTutorial['code'])
            ->withHttpCode($deleteTutorial['code'])
            ->withMessage($deleteTutorial['message'])
            ->withData($deleteTutorial['data'])
            ->build()
            : ResponseBuilder::asError($deleteTutorial['code'])
            ->withHttpCode($deleteTutorial['code'])
            ->withMessage($deleteTutorial['message'])
            ->withData($deleteTutorial['data'])
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
