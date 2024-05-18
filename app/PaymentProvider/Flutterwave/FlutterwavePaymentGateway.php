<?php

namespace App\PaymentProvider\Flutterwave;

use App\Exceptions\ClientErrorException;
use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlutterwavePaymentGateway  implements PaymentGatewayInterface
{
    protected  string $apiUrl = 'https://api.flutterwave.com/v3';


    /**
     * @throws ClientErrorException
     */
    public function fetchBanks()
    {
        return $this->makeRequest('GET', $this->apiUrl.'/banks/NG');
    }

    /**
     * @throws ClientErrorException
     */
    public function resolveBankAccountNumber($data)
    {
        $data['account_bank']  = $data['bank_code'];
        return $this->makeRequest('POST', $this->apiUrl.'/accounts/resolve', Arr::except($data, ['bank_code']));

    }

    /**
     * @throws ClientErrorException
     */
    private function makeRequest($method, $url, $data = [])
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('app.flutterwave_secret'),
                'Cache-Control' => 'no-cache',
            ])->{$method}($url, $data);

            if ($response->successful()) {
                return $response->json()['data'];
            } else {
                $error = $response->json();
                throw new ClientErrorException("Request failed with code: ".$response->status(). " and message : " .$error['message']);
            }
        } catch (\Exception $exception) {
            Log::error('[Flutterwave Payment Gateway] Request failed with error: '.$exception->getMessage());
            throw new ClientErrorException($exception->getMessage());
        }
    }
}
