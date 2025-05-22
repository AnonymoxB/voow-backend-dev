<?php

namespace App\Services\Invitation;

use LaravelEasyRepository\BaseService;

interface InvitationService extends BaseService
{

    // Write something awesome :)
    public function getMyInvitation($request);
    public function showMyInvitation($request);
    public function createInvitation($request);
    public function getMySetting($request);
    public function updateSetting($request);
    public function updateImageSetting($request);
    public function updateTemplate($request);
    public function updateMusic($request);
    public function updateStatusInvitation($request);
}
