<?php

namespace App\Services\User;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use LaravelEasyRepository\Service;
use App\Repositories\User\UserRepository;
use App\Services\Common\Upload\UploadService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class UserServiceImplement extends Service implements UserService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $uploadService;
    protected $userRepository;
    public function __construct(UserRepository $mainRepository,UploadService $uploadService,UserRepository $userRepository)
    {
        $this->mainRepository = $mainRepository;
        $this->uploadService = $uploadService;
        $this->userRepository = $userRepository;
    }

    // Define your custom methods :)

    public function login(LoginRequest $request)
    {
        try {

            $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

            $request->merge([$field => $request->email]);

            if ($field == "email") {
                $checkEmail = $this->mainRepository->getUserByEmail($request->email);

                //Check email first before check credential user
                if (!$checkEmail) {
                    return [
                        'code' => 404,
                        'status' => false,
                        'data' => null,
                        'message' => 'Email Tidak Ditemukan'
                    ];
                }
            }

            if($field == "phone_number"){
                $checkPhoneNumber = $this->mainRepository->getUserByPhoneNumber($request->email);

                //Check Phone Number first before check credential user
                if (!$checkPhoneNumber) {
                    return [
                        'code' => 404,
                        'status' => false,
                        'data' => null,
                        'message' => 'Phone Number Tidak Ditemukan'
                    ];
                }
            }

            //Check credentials user by auth attempt
            if (!$token = auth()->attempt($request->only($field, 'password'))) {
                return [
                    'code' => 400,
                    'status' => false,
                    'data' => null,
                    'message' => 'Email,Phone Number Atau Password Salah'
                ];
            }

            //create token
            $user = auth()->user();
            $token = $user->createToken('voowTokenAuthUser')->plainTextToken;

            return [
                'code' => 200,
                'status' => true,
                'data' => ['token' => $token],
                'message' => 'Success Login'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'name' => $request->name,
                'telphone_number' => $request->telphone_number
            ]);

            $user->addRole('user');

            $token = $user->createToken('voowTokenAuthUser')->plainTextToken;

            return [
                'code' => '200',
                'status' => true,
                'data' => ['token' => $token],
                'message' => 'Success Login'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function profile()
    {
        try {

            $user = $this->userRepository->find(auth()->user()->id);

            $user->userPackage = $user?->userPackage?->package?->name;

            return [
                'code' => 200,
                'status' => true,
                'data' => ['user' => $user],
                'message' => 'Success Get Profile'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateProfile($request)
    {
        try {
            $userData = $this->mainRepository->find(auth()->user()->id);

            $dataRequestUpdate = [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'postal_code' => $request->postal_code
            ];

            if($request->has('avatar')){
                //check file, if exists and delete file from storage
                $this->uploadService->deleteFileUseCloudStorage($userData->getRawOriginal('avatar'));
                //upload file to storage
                $uploadFile = $this->uploadService->uploadFileUsingCloudStorage('user',$request->avatar);

                $dataRequestUpdate['avatar'] = $uploadFile;
            }

            $this->mainRepository->update($userData->id,$dataRequestUpdate);

            return [
                'code' => 200,
                'status' => true,
                'data' => $dataRequestUpdate,
                'message' => 'Success Update Data Profile'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {

            $user = auth()->user();

            $dataPassword = [
                'password' => Hash::make($request->password)
            ];

            $this->mainRepository->update($user->id, $dataPassword);

            return [
                'code' => 200,
                'status' => true,
                'data' => [],
                'message' => 'Success Update Data Password'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function socialLogin($provider)
    {
        try {
            $validated = $this->validateProvider($provider);
            if (!is_null($validated)) {
                return $validated;
            }

            return Socialite::driver($provider)->stateless()->redirect();
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function handleCallbackSocialLogin($provider)
    {
        try {
            $validated = $this->validateProvider($provider);
            if (!is_null($validated)) {
                return $validated;
            }
            $user = Socialite::driver($provider)->stateless()->user();


            $userCreated = User::firstOrCreate(
                [
                    'email' => $user->getEmail()
                ],
                [
                    'email_verified_at' => now(),
                    'name' => $user->getName(),
                    'password' => Hash::make(Str::random(16)),
                    'avatar' => $user->getAvatar()
                ]
            );

            $userCreated->providers()->updateOrCreate(
                [
                    'provider' => $provider,
                    'provider_id' => $user->getId(),
                ],
                [
                    'avatar' => $user->getAvatar()
                ]
            );

            if($userCreated->hasRole('user') == false){
                $userCreated->addRole('user');
            }


            $token = $userCreated->createToken('voowTokenAuthUser')->plainTextToken;

            return redirect()->to('https://voow.vercel.app/login/'.$provider."?token=".$token);

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    private function validateProvider($provider)
    {
        if (!in_array($provider, ['google'])) {
            return [
                'code' => 422,
                'status' => false,
                'data' => null,
                'message' => 'Please login using google'
            ];
        }
    }

    public function getAllUser(){
        try {
            $users = $this->mainRepository->getAllUserData([],0,0,"id","ASC");
            return $users;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
