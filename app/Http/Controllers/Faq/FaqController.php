<?php

namespace App\Http\Controllers\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqCreateRequest;
use App\Http\Requests\Admin\FaqUpdateRequest;
use App\Services\Faq\FaqService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class FaqController extends Controller
{

    protected $faqService;

    function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    //For Landing Page
    public function frontIndex(Request $request)
    {
        try {
            $request['status'] = "Publish";
            $faqData =  $this->faqService->getAllFaq($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Faq Data Succesfully")
                ->withData($faqData)
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }


    //For Admin Panel
    public function adminIndex(Request $request)
    {
        try {
            $faqData =  $this->faqService->getAllFaq($request);

            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Faq Data Succesfully")
                ->withData($faqData)
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function store(FaqCreateRequest $request)
    {

        try {
            $faqData =  $this->faqService->storeFaq($request);


            return $faqData['status'] ? ResponseBuilder::asSuccess($faqData['code'])
                ->withHttpCode($faqData['code'])
                ->withMessage($faqData['message'])
                ->withData($faqData['data'])
                ->build()
                : ResponseBuilder::asError($faqData['code'])
                ->withHttpCode($faqData['code'])
                ->withMessage($faqData['message'])
                ->withData($faqData['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function update(FaqUpdateRequest $request)
    {

        try {
            $updateFaq =  $this->faqService->updateFaq($request);

            return $updateFaq['status'] ? ResponseBuilder::asSuccess($updateFaq['code'])
                ->withHttpCode($updateFaq['code'])
                ->withMessage($updateFaq['message'])
                ->withData($updateFaq['data'])
                ->build()
                : ResponseBuilder::asError($updateFaq['code'])
                ->withHttpCode($updateFaq['code'])
                ->withMessage($updateFaq['message'])
                ->withData($updateFaq['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function show(Request $request)
    {
        try {

            $faqData =  $this->faqService->showFaq($request->id);


            return $faqData['status'] ? ResponseBuilder::asSuccess($faqData['code'])
                ->withHttpCode($faqData['code'])
                ->withMessage($faqData['message'])
                ->withData($faqData['data'])
                ->build()
                : ResponseBuilder::asError($faqData['code'])
                ->withHttpCode($faqData['code'])
                ->withMessage($faqData['message'])
                ->withData($faqData['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function delete(Request $request){
        try {

            $deleteFaq =  $this->faqService->deleteFaq($request->id);

            return $deleteFaq['status'] ? ResponseBuilder::asSuccess($deleteFaq['code'])
                ->withHttpCode($deleteFaq['code'])
                ->withMessage($deleteFaq['message'])
                ->withData($deleteFaq['data'])
                ->build()
                : ResponseBuilder::asError($deleteFaq['code'])
                ->withHttpCode($deleteFaq['code'])
                ->withMessage($deleteFaq['message'])
                ->withData($deleteFaq['data'])
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
