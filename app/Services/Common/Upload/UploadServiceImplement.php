<?php

namespace App\Services\Common\Upload;

use App\Repositories\InvitationImage\InvitationImageRepository;
use LaravelEasyRepository\Service;
use Exception;
use Illuminate\Support\Facades\Storage;

class UploadServiceImplement extends Service implements UploadService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $invitationImageRepository;

    function __construct(InvitationImageRepository $invitationImageRepository)
    {
        $this->invitationImageRepository = $invitationImageRepository;
    }

    public function uploadImage($file, $root_folder, $folderName)
    {
        try {

            $fileNameWithExt = $file->getClientOriginalName();
            $fileNameWithExt = str_replace(" ", "-", $fileNameWithExt);
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
            $filename = urlencode($filename);

            $extension = $file->getClientOriginalExtension();

            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $path = $file->storeAs('files/uploads/' . $root_folder . '/' . $folderName, $fileNameToStore, 'public');

            return $path;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function uploadFileUsingCloudStorage($folder, $file,$array = null)
    {
        try {
            $fileNameWithExt = $file->getClientOriginalName();
            $fileNameWithExt = str_replace(" ", "-", $fileNameWithExt);
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
            $filename = urlencode($filename);

            $extension = $file->getClientOriginalExtension();

            $fileNameToStore = $filename.$array . '_' . time() . '.' . $extension;

            $file->storeAs($folder, $fileNameToStore, 's3');

            return $folder . '/' . $fileNameToStore;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function getFileFromStorage($request)
    {
        try {
            if ($request->filePath) {

                if (Storage::disk('s3')->exists($request->filePath)) {
                    $file = Storage::disk('s3')->get($request->filePath);
                    $contentType = Storage::disk('s3')->mimeType($request->filePath);
                    return response($file)->header('Content-Type', $contentType);
                }

                return abort(404);
            } else {
                return abort(404);
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function deleteFileUseCloudStorage($userFilePath)
    {
        try {
            if ($userFilePath != null) {
                if (Storage::disk('s3')->exists($userFilePath)) {
                    Storage::disk('s3')->delete($userFilePath);
                }
            }

            return true;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function uploadFileInvitation($request)
    {
        try {
            $imageResponse = [];
            if ($request->has('old_images')) {
                foreach ($request->old_images as $old_image) {
                    $urlOldImage = $old_image;
                    $parts = explode('show/', $urlOldImage);
                    if (isset($parts[1])) {
                        $oldFilePath = $parts[1];
                        $this->deleteFileUseCloudStorage($oldFilePath);
                    } else {
                        return [
                            'code' => 400,
                            'status' => false,
                            'data' => ['image' => $old_image],
                            'message' => 'Not Valid Old Image Url'
                        ];
                    }
                }
            }

            if ($request->images) {

                foreach ($request->images as $key => $image) {

                    $checkFileExists = $this->invitationImageRepository->findWhere([[
                        'field_name',$request->field_name[$key]
                    ]]);

                    if($checkFileExists){
                        $checkFileExists->delete();
                    }

                    $imageStorage = $this->uploadFileUsingCloudStorage("invitation/user", $image,$key);
                    $this->invitationImageRepository->create([
                        'field_name' => $request->field_name[$key],
                        'invitation_id' => $request->invitation_id,
                        'path_file' => $imageStorage
                    ]);

                    array_push($imageResponse, url('file/show/' . $imageStorage));
                }
            }

            return [
                'code' => 200,
                'status' => true,
                'data' => ['images' => $imageResponse],
                'message' => 'Success Upload Image Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
