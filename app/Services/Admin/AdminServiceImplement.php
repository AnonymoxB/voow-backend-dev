<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\LoginRequest;
use LaravelEasyRepository\Service;
use App\Repositories\Admin\AdminRepository;
use Exception;

class AdminServiceImplement extends Service implements AdminService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(AdminRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function login(LoginRequest $request){
        try {

            $emailAdmin = $this->mainRepository->getAdminByEmail($request->email);

            if(!$emailAdmin){
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => null,
                    'message' => 'Email Tidak Ditemukan'
                ];
            }


            if (!$token = auth()->attempt(['email' => $request->email,'password' => $request->password])) {
                return [
                    'code' => 400,
                    'status' => false,
                    'data' => null,
                    'message' => 'Email Atau Password Salah'
                ];
            }


            $admin = auth()->user();

            $token = $admin->createToken('voowTokenAuthAdmin')->plainTextToken;

            return [
                'code' => 200,
                'status' => true,
                'data' => ['token' => $token],
                'message' => 'Success Login'
            ];


        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(),500);
        }
    }

    public function profile(){
        try {
            $admin = auth()->user();

            return [
                'code' => 200,
                'status' => true,
                'data' => ['admin' => $admin],
                'message' => 'Success Get Profile'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


}
