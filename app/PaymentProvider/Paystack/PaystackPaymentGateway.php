<?php

namespace App\PaymentProvider\Paystack;

use App\Exceptions\ClientErrorException;
use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackPaymentGateway implements PaymentGatewayInterface
{
    protected  string $apiUrl = 'https://api.paystack.co';


    public function fetchBanks()
    {
        return $this->makeRequest('GET', $this->apiUrl.'/bank');
    }

    public function resolveBankAccountNumber($data)
    {
        return $this->makeRequest('GET', $this->apiUrl.'/bank/resolve', $data);
    }

    /**
     * @throws ClientErrorException
     */
    private function makeRequest($method, $url, $data = [])
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('app.paystack_secret'),
                'Cache-Control' => 'no-cache',
            ])->{$method}($url, $data);

            if ($response->successful()) {
                return $response->json()['data'];
            } else {
                throw new ClientErrorException("Request failed with code: ".$response->status());
            }
        } catch (\Exception $exception) {
            Log::error("[Paystack Payment Gateway] Request failed with error: ".$exception->getMessage());
            throw new ClientErrorException($exception->getMessage());
        }
    }
}
