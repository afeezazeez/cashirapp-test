<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ClientErrorException;
use App\Http\Requests\ResolveAccountRequest;
use App\Http\Resources\BankResource;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * fetch banks
     * @throws ClientErrorException
     */
    public function fetchBanks(): JsonResponse
    {
        $banks = $this->paymentService->fetchBanks();
        return successResponse(BankResource::collection($banks));
    }

    /**
     * resolve bank account number
     * @throws ClientErrorException
     */
    public function resolveBankAccountNumber(ResolveAccountRequest $request): JsonResponse
    {
        $data = $this->paymentService->resolveBankAccountNumber($request->validated());
        return successResponse($data);
    }
}
