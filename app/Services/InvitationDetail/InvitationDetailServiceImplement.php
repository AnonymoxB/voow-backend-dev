<?php

namespace App\Services\InvitationDetail;

use LaravelEasyRepository\Service;
use App\Repositories\InvitationDetail\InvitationDetailRepository;
use Exception;

class InvitationDetailServiceImplement extends Service implements InvitationDetailService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(InvitationDetailRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function updateInvitation($request)
    {
        try {
            $findInvitationDetail = $this->mainRepository->whereFirst([[
                'invitation_id', $request->invitation_id
            ]]);

            $arrayUpdate = [];

            $fields = ['opening', 'home', 'couple', 'date', 'story','gallery','gift','rsvp','thanks'];

            foreach ($fields as $field) {
                if ($request->$field) {
                    $arrayUpdate[$field] = json_encode($request->$field);
                }
            }

            if($arrayUpdate == null){
                return [
                    'code' => 200,
                    'status' => true,
                    'data' => $request->all(),
                    'message' => 'Success Update My Invitation'
                ];

            }

            $findInvitationDetail->update($arrayUpdate);

            return [
                'code' => 200,
                'status' => true,
                'data' => $request->all(),
                'message' => 'Success Update My Invitation'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
