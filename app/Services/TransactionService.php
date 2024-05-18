<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{

    public function getTransactions(int $limit)
    {
        return Transaction::latest()->paginate($limit);
    }
}
