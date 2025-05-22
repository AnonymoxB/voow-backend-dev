<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PaymentRequest;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class PaymentController extends Controller
{
    protected $paymentService;
    function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function pay(PaymentRequest $request){
        try {
            $paymentRequest =  $this->paymentService->createInvoice($request);

            return $paymentRequest['status'] ? ResponseBuilder::asSuccess($paymentRequest['code'])
                ->withHttpCode($paymentRequest['code'])
                ->withMessage($paymentRequest['message'])
                ->withData($paymentRequest['data'])
                ->build()
                : ResponseBuilder::asError($paymentRequest['code'])
                ->withHttpCode($paymentRequest['code'])
                ->withMessage($paymentRequest['message'])
                ->withData($paymentRequest['data'])
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
