<?php

namespace App\Services\Payment;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface PaymentService extends BaseService{

    // Write something awesome :)
    public function createInvoice(Request $request);
}
