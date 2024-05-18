<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionService
{

    public function getTransactions(array $meta): LengthAwarePaginator
    {
        return Transaction::latest()
            ->when(isset($meta['query']), function ($query) use ($meta) {
                $query->where(function ($query) use ($meta) {
                    $query->where('reference', 'like', "%{$meta['query']}%")
                        ->orWhere('description', 'like', "%{$meta['query']}%")
                        ->orWhere('type', 'like', "%{$meta['query']}%")
                        ->orWhere('status', 'like', "%{$meta['query']}%");
                });
            })
            ->when(isset($meta['filter']), function ($query) use ($meta) {
                $query->where(function ($query) use ($meta) {
                    switch ($meta['filter']) {
                        case 'month':
                            $query->whereMonth('date', date('m'));
                            break;
                        case 'day':
                            $query->whereDay('date', date('d'));
                            break;
                        case 'year':
                            $query->whereYear('date', date('Y'));
                            break;
                    }
                });
            })
            ->paginate($meta['page_size']);
    }
}
