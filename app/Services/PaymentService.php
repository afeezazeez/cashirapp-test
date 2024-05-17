<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\PaymentProvider\PaymentGatewayFactory;
use Illuminate\Support\Facades\Log;

class PaymentService
{

    protected mixed $paymentGatewayFactory;

    public function __construct()
    {
        $this->paymentGatewayFactory = new PaymentGatewayFactory();
    }

    /**
     * @throws ClientErrorException
     */
    public function fetchBanks(): array|null
    {
        return $this->handlePaymentRequest(
            function ($exception) {
                return 'Unable to fetch banks. Please try again later';
            },
            function ($provider) {
                return $provider->fetchBanks();
            },
            'Fetching of bank'
        );
    }

    /**
     * @throws ClientErrorException
     */
    public function resolveBankAccountNumber(array $data)
    {
        return $this->handlePaymentRequest(
            function ($exception) {
                return 'Unable to resolve banks. Please try again later';
            },
            function ($provider) use ($data) {
                return $provider->resolveBankAccountNumber($data);
            },
            'Resolving bank details'
        );
    }

    /**
     * @throws ClientErrorException
     */
    private function handlePaymentRequest(callable $errorMessage, callable $paymentAction, string $logMessage)
    {
        try {
            $provider = $this->paymentGatewayFactory->getProvider();
            return $paymentAction($provider);
        } catch (ClientErrorException $exception) {
            if ($this->paymentGatewayFactory->hasNextProvider()) {
                Log::error("[Payment Service] Payment provider : " . ucfirst($this->paymentGatewayFactory->currentProvider) . " failed.");
                Log::error("[Payment Service] Attempting next payment provider: " . ucfirst($this->paymentGatewayFactory->getNextProvider()));
                $this->paymentGatewayFactory->setNextProvider();
                return $this->handlePaymentRequest($errorMessage, $paymentAction, $logMessage);
            }
            Log::error("[Payment Service] $logMessage failed after attempting all payment providers. Error : " . $exception->getMessage());
            throw new ClientErrorException($errorMessage($exception));
        }
    }
}
