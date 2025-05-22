<?php

namespace App\Services\Music;

use LaravelEasyRepository\Service;
use App\Repositories\Music\MusicRepository;
use App\Services\Common\Upload\UploadService;
use Exception;

class MusicServiceImplement extends Service implements MusicService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $uploadService;

    public function __construct(MusicRepository $mainRepository, UploadService $uploadService)
    {
        $this->mainRepository = $mainRepository;
        $this->uploadService = $uploadService;
    }


    public function get($request)
    {
        try {
            $where = [];
            if ($request->status) {
                $where = [
                    'status' => $request->status
                ];
            }

            $musicData = $this->mainRepository->getAllData($where, 0, 0, "id", "ASC", []);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['music' => $musicData],
                'message' => 'Success Get Music'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    // Define your custom methods :)
    public function store($request)
    {
        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'status' => 1
            ];

            if ($request->has('music')) {
                //upload file to storage
                $uploadFile = $this->uploadService->uploadFileUsingCloudStorage('music', $request->music);

                $data['link'] = $uploadFile;
            }


            $this->mainRepository->create($data);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['music' => $data],
                'message' => 'Success Create Music'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
