<?php

namespace App\Services\DashboardUser;

use LaravelEasyRepository\Service;
use App\Repositories\DashboardUser\DashboardUserRepository;
use App\Repositories\Invitation\InvitationRepository;
use App\Repositories\InvitationGuestBook\InvitationGuestBookRepository;
use App\Repositories\InvitationRsvp\InvitationRsvpRepository;
use Illuminate\Support\Facades\Auth;

class DashboardUserServiceImplement extends Service implements DashboardUserService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $invitationRepository;
     protected $guestBookRepository;
     protected $rsvpRepository;
    public function __construct(InvitationRepository $invitationRepository,InvitationGuestBookRepository $guestBookRepository,InvitationRsvpRepository $rsvpRepository)
    {
      $this->invitationRepository = $invitationRepository;
      $this->guestBookRepository = $guestBookRepository;
      $this->rsvpRepository = $rsvpRepository;
    }

    public function countDataDashboardUser(){

        $totalInvitationUser = $this->invitationRepository->whereGet([[
            'user_id',Auth::user()->id
        ],[
            'parent_id',null
        ]]);

        $totalGuest = $this->guestBookRepository->whereRelationGet([],'invitation',[[
            'user_id',Auth::user()->id
        ]]);

        $totalWish = $this->rsvpRepository->whereRelationGet([[
            'wish','!=',null
        ]],'invitation',[[
            'user_id',Auth::user()->id
        ]]);


        $totalDataCount =  [
            'total_invitation' => $totalInvitationUser->count(),
            'total_guest' => $totalGuest->count(),
            'total_wish' => $totalWish->count()
        ];

        return [
            'code' => 200,
            'status' => true,
            'data' => ['count' => $totalDataCount],
            'message' => 'Success Get All Count Data Dashboard User'
        ];
    }
}
