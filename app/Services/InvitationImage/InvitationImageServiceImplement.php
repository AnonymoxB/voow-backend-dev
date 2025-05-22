<?php

namespace App\Services\InvitationImage;

use LaravelEasyRepository\Service;
use App\Repositories\InvitationImage\InvitationImageRepository;

class InvitationImageServiceImplement extends Service implements InvitationImageService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(InvitationImageRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
