<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;
    protected int $page_size;

    public function __construct(TransactionService $transactionService)
    {
      $this->transactionService = $transactionService;
      $this->page_size = (request()->has('perPage') && is_numeric(request('perPage'))) ? request('perPage') : config('app.default_pagination_size');
    }

    /**
     * get transactions
     */
    public function index(): JsonResponse
    {

        $transactions = $this->transactionService->getTransactions($this->page_size);
        return successResponse(TransactionResource::collection($transactions)->resource);
    }

}

