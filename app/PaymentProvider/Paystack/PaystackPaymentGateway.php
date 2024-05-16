<?php

namespace App\PaymentProvider\Paystack;

use App\Exceptions\ClientErrorException;
use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackPaymentGateway implements PaymentGatewayInterface
{

    protected string $banks_api = 'https://api.paystack.co/beeank';

    protected string $resolve_account_api = 'https://api.paystack.co/bank/resolve';

    /**
     * @throws ClientErrorException
     */
    public function fetchBanks()
    {
        // set timeout
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('app.paystack_secret'),
            'Cache-Control' => 'no-cache',
        ])->timeout(10)->get($this->banks_api);

        if ($response->successful()) {

            return $response->json()['data'];

        } else {
            Log::error("[Paystack Payment Gateway] Fetching of bank failed with status code: ".$response->status());
           throw new ClientErrorException("Fetching of bank failed with status code: ".$response->status());

        }
    }

    /**
     * @throws ClientErrorException
     */
    public function resolveBankAccountNumber($data)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('app.paystack_secret'),
            'Cache-Control' => 'no-cache',
        ])->get($this->resolve_account_api, [
            'account_number' => $data['account_number'],
            'bank_code' => $data['bank_code'],
        ]);

        if ($response->successful()) {

            return $response->json()['data'];

        } else {
            throw new ClientErrorException("Resolving failed with status code: ".$response->status());

        }
    }
}
