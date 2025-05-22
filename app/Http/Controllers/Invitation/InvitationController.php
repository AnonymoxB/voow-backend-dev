<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\InvitationCreateRequest;
use App\Http\Requests\User\InvitationSettingUpdate;
use App\Http\Requests\User\UpdateImageSettingRequest;
use App\Http\Requests\User\UpdateInvitationRequest;
use App\Http\Requests\User\UpdateTemplateInvitationRequest;
use App\Http\Requests\User\UpdateMusicInvitationRequest;
use App\Http\Requests\User\UpdateStatusInvitationRequest;
use App\Http\Requests\User\UploadImageRequest;
use App\Services\Common\Upload\UploadService;
use App\Services\Invitation\InvitationService;
use App\Services\InvitationDetail\InvitationDetailService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class InvitationController extends Controller
{

    function __construct(protected InvitationService $invitationService,protected UploadService $uploadService,protected InvitationDetailService $invitationDetailService)
    {
        $this->invitationService = $invitationService;
        $this->uploadService = $uploadService;
        $this->invitationDetailService = $invitationDetailService;
    }

    public function myInvitation(Request $request){
        try {
            $myInvitation = $this->invitationService->getMyInvitation($request);

            return $myInvitation['status'] ? ResponseBuilder::asSuccess($myInvitation['code'])
                ->withHttpCode($myInvitation['code'])
                ->withMessage($myInvitation['message'])
                ->withData($myInvitation['data'])
                ->build()
                : ResponseBuilder::asError($myInvitation['code'])
                ->withHttpCode($myInvitation['code'])
                ->withMessage($myInvitation['message'])
                ->withData($myInvitation['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function createInvitation(InvitationCreateRequest $request){
        try {
            $invitationCreate = $this->invitationService->createInvitation($request);

            return $invitationCreate['status'] ? ResponseBuilder::asSuccess($invitationCreate['code'])
                ->withHttpCode($invitationCreate['code'])
                ->withMessage($invitationCreate['message'])
                ->withData($invitationCreate['data'])
                ->build()
                : ResponseBuilder::asError($invitationCreate['code'])
                ->withHttpCode($invitationCreate['code'])
                ->withMessage($invitationCreate['message'])
                ->withData($invitationCreate['data'])
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage("Something Wrong")
                ->withData($th->getMessage())
                ->build();
        }
    }

    public function showMyInvitation($request){
        try {
            return $showMyInvitation = $this->invitationService->showMyInvitation($request);

            return $showMyInvitation['status'] ? ResponseBuilder::asSuccess($showMyInvitation['code'])
                ->withHttpCode($showMyInvitation['code'])
                ->withMessage($showMyInvitation['message'])
                ->withData($showMyInvitation['data'])
                ->build()
                : ResponseBuilder::asError($showMyInvitation['code'])
                ->withHttpCode($showMyInvitation['code'])
                ->withMessage($showMyInvitation['message'])
                ->withData($showMyInvitation['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function uploadImageInvitation(UploadImageRequest $request){
        try {
            $uploadImage = $this->uploadService->uploadFileInvitation($request);

            return $uploadImage['status'] ? ResponseBuilder::asSuccess($uploadImage['code'])
                ->withHttpCode($uploadImage['code'])
                ->withMessage($uploadImage['message'])
                ->withData($uploadImage['data'])
                ->build()
                : ResponseBuilder::asError($uploadImage['code'])
                ->withHttpCode($uploadImage['code'])
                ->withMessage($uploadImage['message'])
                ->withData($uploadImage['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();        }
    }

    public function getMySetting($request){
        try {
             $getMySettingInvitation = $this->invitationService->getMySetting($request);

            return $getMySettingInvitation['status'] ? ResponseBuilder::asSuccess($getMySettingInvitation['code'])
                ->withHttpCode($getMySettingInvitation['code'])
                ->withMessage($getMySettingInvitation['message'])
                ->withData($getMySettingInvitation['data'])
                ->build()
                : ResponseBuilder::asError($getMySettingInvitation['code'])
                ->withHttpCode($getMySettingInvitation['code'])
                ->withMessage($getMySettingInvitation['message'])
                ->withData($getMySettingInvitation['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function updateSetting(InvitationSettingUpdate $request){
        try {

        $updateSetting = $this->invitationService->updateSetting($request);

            return $updateSetting['status'] ? ResponseBuilder::asSuccess($updateSetting['code'])
                ->withHttpCode($updateSetting['code'])
                ->withMessage($updateSetting['message'])
                ->withData($updateSetting['data'])
                ->build()
                : ResponseBuilder::asError($updateSetting['code'])
                ->withHttpCode($updateSetting['code'])
                ->withMessage($updateSetting['message'])
                ->withData($updateSetting['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function updateImageSetting(UpdateImageSettingRequest $request){
        try {

            $updateSetting = $this->invitationService->updateImageSetting($request);

            return $updateSetting['status'] ? ResponseBuilder::asSuccess($updateSetting['code'])
                ->withHttpCode($updateSetting['code'])
                ->withMessage($updateSetting['message'])
                ->withData($updateSetting['data'])
                ->build()
                : ResponseBuilder::asError($updateSetting['code'])
                ->withHttpCode($updateSetting['code'])
                ->withMessage($updateSetting['message'])
                ->withData($updateSetting['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function updateTemplate(UpdateTemplateInvitationRequest $request){
         try {

            $updateTemplate = $this->invitationService->UpdateTemplate($request);

            return $updateTemplate['status'] ? ResponseBuilder::asSuccess($updateTemplate['code'])
                ->withHttpCode($updateTemplate['code'])
                ->withMessage($updateTemplate['message'])
                ->withData($updateTemplate['data'])
                ->build()
                : ResponseBuilder::asError($updateTemplate['code'])
                ->withHttpCode($updateTemplate['code'])
                ->withMessage($updateTemplate['message'])
                ->withData($updateTemplate['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function updateMusic(UpdateMusicInvitationRequest $request){
        try {
           $updateMusic = $this->invitationService->updateMusic($request);

           return $updateMusic['status'] ? ResponseBuilder::asSuccess($updateMusic['code'])
               ->withHttpCode($updateMusic['code'])
               ->withMessage($updateMusic['message'])
               ->withData($updateMusic['data'])
               ->build()
               : ResponseBuilder::asError($updateMusic['code'])
               ->withHttpCode($updateMusic['code'])
               ->withMessage($updateMusic['message'])
               ->withData($updateMusic['data'])
               ->build();
       } catch (\Throwable $th) {
           return ResponseBuilder::asError(500)
           ->withHttpCode(500)
           ->withMessage("Something Wrong")
           ->withData($th->getMessage())
           ->build();
       }
    }

    public function updateInvitation(UpdateInvitationRequest $request){
        try {
            $updateMyInvitation = $this->invitationDetailService->updateInvitation($request);

            return $updateMyInvitation['status'] ? ResponseBuilder::asSuccess($updateMyInvitation['code'])
                ->withHttpCode($updateMyInvitation['code'])
                ->withMessage($updateMyInvitation['message'])
                ->withData($updateMyInvitation['data'])
                ->build()
                : ResponseBuilder::asError($updateMyInvitation['code'])
                ->withHttpCode($updateMyInvitation['code'])
                ->withMessage($updateMyInvitation['message'])
                ->withData($updateMyInvitation['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function updateStatusInvitation(UpdateStatusInvitationRequest $request){
        try {
            $updateStatusMyInvitation = $this->invitationService->updateStatusInvitation($request);

            return $updateStatusMyInvitation['status'] ? ResponseBuilder::asSuccess($updateStatusMyInvitation['code'])
                ->withHttpCode($updateStatusMyInvitation['code'])
                ->withMessage($updateStatusMyInvitation['message'])
                ->withData($updateStatusMyInvitation['data'])
                ->build()
                : ResponseBuilder::asError($updateStatusMyInvitation['code'])
                ->withHttpCode($updateStatusMyInvitation['code'])
                ->withMessage($updateStatusMyInvitation['message'])
                ->withData($updateStatusMyInvitation['data'])
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
