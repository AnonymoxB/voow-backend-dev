<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Services\Transaction\TransactionService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class TransactionController extends Controller
{
    protected $transactionService;

    function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function adminIndex(Request $request){
        try {
            $transactionData =$this->transactionService->getAllTransaction($request);
            return ResponseBuilder::asSuccess(200)
            ->withHttpCode(200)
            ->withMessage("Get Transaction Data Succesfully")
            ->withData($transactionData)
            ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function getMyTransactionIndex(){
        try {
            $transactionData =$this->transactionService->getMyTransaction();

            return ResponseBuilder::asSuccess(200)
            ->withHttpCode(200)
            ->withMessage("Get Transaction Data Succesfully")
            ->withData($transactionData)
            ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError(500)
            ->withHttpCode(500)
            ->withMessage("Something Wrong")
            ->withData($th->getMessage())
            ->build();
        }
    }

    public function transactionCallback(Request $request){

        $paymentCallback = $this->transactionService->transactionCallback($request);

        return $paymentCallback['status'] ? ResponseBuilder::asSuccess($paymentCallback['code'])
        ->withHttpCode($paymentCallback['code'])
        ->withMessage($paymentCallback['message'])
        ->withData($paymentCallback['data'])
        ->build()
        : ResponseBuilder::asError($paymentCallback['code'])
        ->withHttpCode($paymentCallback['code'])
        ->withMessage($paymentCallback['message'])
        ->withData($paymentCallback['data'])
        ->build();

    }


}
