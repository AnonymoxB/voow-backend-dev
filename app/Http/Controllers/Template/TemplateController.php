<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use App\Services\Template\TemplateService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class TemplateController extends Controller
{
    protected $templateService;

    function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function frontIndex(Request $request){
        try {
            $request['status'] = "Publish";
            $templateData = $this->templateService->getAllTemplate($request);


            return ResponseBuilder::asSuccess(200)
                ->withHttpCode(200)
                ->withMessage("Get Template Data Succesfully")
                ->withData($templateData)
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
