<?php

namespace App\Repositories\Transaction;

use LaravelEasyRepository\Repository;

interface TransactionRepository extends Repository{

    // Write something awesome :)
    public function findPendingTransactionByUser($userId);
    public function getTransactionByUser($userId);
    public function getTransactionByInvoice($invoice);
    public function getAllData($where = array(), $limit = 0, $offset = 1, $sort_column = "id", $sort_order = "ASC", $with = array());
}
