<?php

namespace App\Http\Controllers\GuestBook;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadExcelGuestBookRequest;
use App\Services\InvitationGuestBook\InvitationGuestBookService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Illuminate\Support\Str;


class GuestBookController extends Controller
{
    function __construct(protected InvitationGuestBookService $invitationGuestBookService)
    {
        $this->invitationGuestBookService = $invitationGuestBookService;
    }

    public function index(Request $request){
        try {
             $myGuestBook = $this->invitationGuestBookService->getAllGuestBook($request);

            return $myGuestBook['status'] ? ResponseBuilder::asSuccess($myGuestBook['code'])
                ->withHttpCode($myGuestBook['code'])
                ->withMessage($myGuestBook['message'])
                ->withData($myGuestBook['data'])
                ->build()
                : ResponseBuilder::asError($myGuestBook['code'])
                ->withHttpCode($myGuestBook['code'])
                ->withMessage($myGuestBook['message'])
                ->withData($myGuestBook['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function store(Request $request){
        try {
            $storeMyGuestBook = $this->invitationGuestBookService->storeGuestBook($request);

            return $storeMyGuestBook['status'] ? ResponseBuilder::asSuccess($storeMyGuestBook['code'])
                ->withHttpCode($storeMyGuestBook['code'])
                ->withMessage($storeMyGuestBook['message'])
                ->withData($storeMyGuestBook['data'])
                ->build()
                : ResponseBuilder::asError($storeMyGuestBook['code'])
                ->withHttpCode($storeMyGuestBook['code'])
                ->withMessage($storeMyGuestBook['message'])
                ->withData($storeMyGuestBook['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function show(Request $request){
        try {
            $showMyGuestBook = $this->invitationGuestBookService->showGuestBook($request);

            return $showMyGuestBook['status'] ? ResponseBuilder::asSuccess($showMyGuestBook['code'])
                ->withHttpCode($showMyGuestBook['code'])
                ->withMessage($showMyGuestBook['message'])
                ->withData($showMyGuestBook['data'])
                ->build()
                : ResponseBuilder::asError($showMyGuestBook['code'])
                ->withHttpCode($showMyGuestBook['code'])
                ->withMessage($showMyGuestBook['message'])
                ->withData($showMyGuestBook['data'])
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function update(Request $request){
        try {
            $updateMyInvitation = $this->invitationGuestBookService->updateGuestBook($request);

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

    public function delete(Request $request){
        try {
             $deleteMyGuestBook = $this->invitationGuestBookService->deleteGuestBook($request);

            return $deleteMyGuestBook['status'] ? ResponseBuilder::asSuccess($deleteMyGuestBook['code'])
                ->withHttpCode($deleteMyGuestBook['code'])
                ->withMessage($deleteMyGuestBook['message'])
                ->withData($deleteMyGuestBook['data'])
                ->build()
                : ResponseBuilder::asError($deleteMyGuestBook['code'])
                ->withHttpCode($deleteMyGuestBook['code'])
                ->withMessage($deleteMyGuestBook['message'])
                ->withData($deleteMyGuestBook['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function importFromExcel(UploadExcelGuestBookRequest $request){
        try {
            $importFromExcel = $this->invitationGuestBookService->importFromExcelGuestBook($request);

            return $importFromExcel['status'] ? ResponseBuilder::asSuccess($importFromExcel['code'])
                ->withHttpCode($importFromExcel['code'])
                ->withMessage($importFromExcel['message'])
                ->withData($importFromExcel['data'])
                ->build()
                : ResponseBuilder::asError($importFromExcel['code'])
                ->withHttpCode($importFromExcel['code'])
                ->withMessage($importFromExcel['message'])
                ->withData($importFromExcel['data'])
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function exportFromExcel(Request $request){
        try {
            return $this->invitationGuestBookService->exportToExcelGuestBook($request);
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function getGuestBookData(Request $request){
        try {
            $guestBook = $this->invitationGuestBookService->getGuestBookData($request);

            return $guestBook['status'] ? ResponseBuilder::asSuccess($guestBook['code'])
            ->withHttpCode($guestBook['code'])
            ->withMessage($guestBook['message'])
            ->withData($guestBook['data'])
            ->build()
            : ResponseBuilder::asError($guestBook['code'])
            ->withHttpCode($guestBook['code'])
            ->withMessage($guestBook['message'])
            ->withData($guestBook['data'])
            ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function getScanGuestBookData(Request $request){
        try {
            $guestBook = $this->invitationGuestBookService->getDataScanGuestBook($request);

            return $guestBook['status'] ? ResponseBuilder::asSuccess($guestBook['code'])
            ->withHttpCode($guestBook['code'])
            ->withMessage($guestBook['message'])
            ->withData($guestBook['data'])
            ->build()
            : ResponseBuilder::asError($guestBook['code'])
            ->withHttpCode($guestBook['code'])
            ->withMessage($guestBook['message'])
            ->withData($guestBook['data'])
            ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function scanGuestBookData(Request $request){
        try {
            $guestBook = $this->invitationGuestBookService->scanGuestBook($request);

            return $guestBook['status'] ? ResponseBuilder::asSuccess($guestBook['code'])
            ->withHttpCode($guestBook['code'])
            ->withMessage($guestBook['message'])
            ->withData($guestBook['data'])
            ->build()
            : ResponseBuilder::asError($guestBook['code'])
            ->withHttpCode($guestBook['code'])
            ->withMessage($guestBook['message'])
            ->withData($guestBook['data'])
            ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }


    public function getSendMessage(Request $request){
        try {
            $sendMessage = $this->invitationGuestBookService->getDataMessage($request);

            return $sendMessage['status'] ? ResponseBuilder::asSuccess($sendMessage['code'])
            ->withHttpCode($sendMessage['code'])
            ->withMessage($sendMessage['message'])
            ->withData($sendMessage['data'])
            ->build()
            : ResponseBuilder::asError($sendMessage['code'])
            ->withHttpCode($sendMessage['code'])
            ->withMessage($sendMessage['message'])
            ->withData($sendMessage['data'])
            ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }


    public function sendMessage(Request $request){
        try {
            $sendMessage = $this->invitationGuestBookService->sendMessage($request);

            return $sendMessage['status'] ? ResponseBuilder::asSuccess($sendMessage['code'])
            ->withHttpCode($sendMessage['code'])
            ->withMessage($sendMessage['message'])
            ->withData($sendMessage['data'])
            ->build()
            : ResponseBuilder::asError($sendMessage['code'])
            ->withHttpCode($sendMessage['code'])
            ->withMessage($sendMessage['message'])
            ->withData($sendMessage['data'])
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
