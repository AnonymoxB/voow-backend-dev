<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MusicCreateRequest;
use App\Services\Music\MusicService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class MusicController extends Controller
{
    protected $musicService;

    function __construct(MusicService $musicService)
    {
        $this->musicService = $musicService;
    }

    public function frontIndex(Request $request){
        try {

            $musicData =  $this->musicService->get($request);

            return $musicData['status'] ? ResponseBuilder::asSuccess($musicData['code'])
                ->withHttpCode($musicData['code'])
                ->withMessage($musicData['message'])
                ->withData($musicData['data'])
                ->build()
                : ResponseBuilder::asError($musicData['code'])
                ->withHttpCode($musicData['code'])
                ->withMessage($musicData['message'])
                ->withData($musicData['data'])
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function storeAdmin(MusicCreateRequest $request){
        try {

            $musicData =  $this->musicService->store($request);

            return $musicData['status'] ? ResponseBuilder::asSuccess($musicData['code'])
                ->withHttpCode($musicData['code'])
                ->withMessage($musicData['message'])
                ->withData($musicData['data'])
                ->build()
                : ResponseBuilder::asError($musicData['code'])
                ->withHttpCode($musicData['code'])
                ->withMessage($musicData['message'])
                ->withData($musicData['data'])
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
