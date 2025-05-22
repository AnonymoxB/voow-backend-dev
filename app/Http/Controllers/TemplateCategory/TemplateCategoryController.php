<?php

namespace App\Http\Controllers\TemplateCategory;

use App\Http\Controllers\Controller;
use App\Services\TemplateCategory\TemplateCategoryService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class TemplateCategoryController extends Controller
{
    protected $templateCategoryService;

    function __construct(TemplateCategoryService $templateCategoryService)
    {
        $this->templateCategoryService = $templateCategoryService;
    }

    public function frontIndex(Request $request){
        try {
            $templateCategory = $this->templateCategoryService->getAllTemplateCategory($request);


            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Template Category Data Succesfully")
                ->withData($templateCategory)
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function frontShow($slug){
        try {

            $templateCategory = $this->templateCategoryService->showTemplateCategory($slug);


            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Show Template Category Data Succesfully")
                ->withData($templateCategory)
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
