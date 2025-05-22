<?php

namespace App\Http\Controllers\Rsvp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\CreateRsvpRequest;
use App\Services\InvitationRsvp\InvitationRsvpService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class RsvpController extends Controller
{
    function __construct(protected InvitationRsvpService $invitationRsvpService)
    {
        $this->invitationRsvpService = $invitationRsvpService;
    }

    public function storeRsvp(CreateRsvpRequest $request){
        try {
        $createRsvpGuest = $this->invitationRsvpService->storeRsvp($request);

           return $createRsvpGuest['status'] ? ResponseBuilder::asSuccess($createRsvpGuest['code'])
               ->withHttpCode($createRsvpGuest['code'])
               ->withMessage($createRsvpGuest['message'])
               ->withData($createRsvpGuest['data'])
               ->build()
               : ResponseBuilder::asError($createRsvpGuest['code'])
               ->withHttpCode($createRsvpGuest['code'])
               ->withMessage($createRsvpGuest['message'])
               ->withData($createRsvpGuest['data'])
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
