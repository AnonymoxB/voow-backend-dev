<?php

namespace App\Services\Common\Upload;

use LaravelEasyRepository\BaseService;

interface UploadService extends BaseService{

    // Write something awesome :)
    public function uploadImage($file,$root_folder,$folderName);
    public function uploadFileUsingCloudStorage($folder,$file);
    public function getFileFromStorage($request);
    public function deleteFileUseCloudStorage($userFilePath);
    public function uploadFileInvitation($request);
}
