<?php

namespace App\Services\Transaction;

use App\Models\TransactionCallback;
use LaravelEasyRepository\Service;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\UserPackage\UserPackageRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class TransactionServiceImplement extends Service implements TransactionService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;
     protected $callbackToken;
     protected $userPackageRepository;
    public function __construct(TransactionRepository $mainRepository,UserPackageRepository $userPackageRepository)
    {
      $this->mainRepository = $mainRepository;
      $this->callbackToken = "Xwmnhv2L5UumLLHdoYAL9At52oUEKP0RX1xr5Wb3AaCANVLy";
      $this->userPackageRepository = $userPackageRepository;

    }

    // Define your custom methods :)
    public function getAllTransaction($request){
        try {
            $limit = $request->limit ?? 0;
            $allTransaction =  $this->mainRepository->getAllData([],$limit,0,"id","ASC",['user','package']);
            return $allTransaction;

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function getMyTransaction(){
        try {

            $myTransaction =  $this->mainRepository->getTransactionByUser(Auth::user()->id);
            return $myTransaction;

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function transactionCallback($request){
        try {

            if($request->header('x-callback-token') != $this->callbackToken){
                return [
                    'code' => 400,
                    'status' => false,
                    'data' => ['transaction' => []],
                    'message' => 'Token Not Valid'
                ];
            }

            $transaction =  $this->mainRepository->getTransactionByInvoice($request->external_id);

            if(!$transaction){
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => ['transaction' => []],
                    'message' => 'Transaction Not Found'
                ];
            }

            if($transaction){
                if($request->status == "PAID"){

                    $dataUserPackage = [
                        'transaction_id' => $transaction->id,
                        'package_id' => $transaction->package_id,
                        'user_id' => $transaction->user_id
                    ];

                    $this->userPackageRepository->create($dataUserPackage);

                    $transaction->update([
                        'status' => 'Success'
                    ]);


                }else{
                    $transaction->update([
                        'status' => 'Expired'
                    ]);
                }


            }

            TransactionCallback::create([
                'raw_json' => json_encode($request->all())
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['transaction' => $transaction],
                'message' => 'Transaction Callback Success'
            ];


        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);


        }
    }

}
