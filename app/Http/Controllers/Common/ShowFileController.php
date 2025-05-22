<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Services\Common\Upload\UploadService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ShowFileController extends Controller
{
    protected $uploadService;
    function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function showFile(Request $request){
        return $this->uploadService->getFileFromStorage($request);

    }
}
