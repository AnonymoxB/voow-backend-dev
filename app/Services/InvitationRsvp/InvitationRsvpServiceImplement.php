<?php

namespace App\Services\InvitationRsvp;

use LaravelEasyRepository\Service;
use App\Repositories\InvitationRsvp\InvitationRsvpRepository;
use Exception;

class InvitationRsvpServiceImplement extends Service implements InvitationRsvpService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(InvitationRsvpRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function storeRsvp($request)
    {
        try {
            $findRsvp = $this->mainRepository->whereFirst([
                [
                    'invitation_id', $request->invitation_id,
                ],
                ['invitation_guest_book_id', $request->invitation_guest_book_id,]
            ]);

            if($findRsvp){
                return [
                    'code' => 200,
                    'status' => true,
                    'data' => ['invitation_rsvp' => $request->all()],
                    'message' => 'Success Create Invitation Rsvp'
                ];
            }

            $this->mainRepository->create([
                'invitation_id' => $request->invitation_id,
                'invitation_guest_book_id' => $request->invitation_guest_book_id,
                'name' => $request->name,
                'is_present' => $request->is_present
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['invitation_rsvp' => $request->all()],
                'message' => 'Success Create Invitation Rsvp'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
