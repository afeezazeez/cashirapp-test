<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\PaymentProvider\PaymentGatewayFactory;
use Illuminate\Support\Facades\Log;


class PaymentService
{

    protected mixed $provider;


    /**
     * @throws ClientErrorException
     */
    public function fetchBanks(): array|null
    {
        try {
                $provider = PaymentGatewayFactory::getProvider();
                Log::info('provider: '.class_basename($provider));
                $provider->fetchBanks();
        } catch (ClientErrorException $exception) {
            if (PaymentGatewayFactory::hasNextProvider()) {
                PaymentGatewayFactory::setNextProvider();
                Log::error("[Payment Service] Attempting next payment provider: ". PaymentGatewayFactory::getNextProvider());
                return $this->fetchBanks();
            }
            Log::error("[Payment Service] Fetching of bank failed after attempting all payment providers");
            Log::error($exception->getMessage());
            throw new ClientErrorException('Fetching of bank failed after attempting all payment providers');
        }
    }

    public function resolveBankAccountNumber(array $data)
    {
       return $this->provider->resolveBankAccountNumber($data);
    }
}
