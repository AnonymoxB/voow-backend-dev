<?php

namespace App\Services\Transaction;

use LaravelEasyRepository\BaseService;

interface TransactionService extends BaseService{

    // Write something awesome :)
    public function getAllTransaction($request);
    public function getMyTransaction();
    public function transactionCallback($request);
}
