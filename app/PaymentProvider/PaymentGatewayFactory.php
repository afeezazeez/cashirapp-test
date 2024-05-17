<?php

namespace App\PaymentProvider;


use App\Interfaces\PaymentGatewayInterface;
use App\PaymentProvider\Flutterwave\FlutterwavePaymentGateway;
use App\PaymentProvider\Paystack\PaystackPaymentGateway;



class PaymentGatewayFactory
{
    private array $services = [
        'flutterwave' => FlutterwavePaymentGateway::class,
        'paystack' => PaystackPaymentGateway::class,
    ];

    private array $usedServices = [];


    public string $currentProvider;

    public function __construct()
    {
        $this->currentProvider = config('app.default_payment_provider');
    }

    /**
     */
    public  function getProvider(): PaymentGatewayInterface
    {
        $serviceClass = $this->services[$this->currentProvider];

        $this->usedServices[] = $this->currentProvider;

        return new $serviceClass();
    }

    public  function hasNextProvider(): bool
    {
        return count($this->usedServices) < count($this->services);
    }

    public  function setNextProvider(): void
    {
        $keys = array_keys($this->services);
        $currentProviderIndex = array_search($this->currentProvider, $keys);
        $nextProviderIndex = ($currentProviderIndex + 1) % count($this->services);
        $this->currentProvider = $keys[$nextProviderIndex];
    }

    public  function getNextProvider(): string
    {
        $keys = array_keys($this->services);
        $currentProviderIndex = array_search($this->currentProvider, $keys);
        $nextProviderIndex = ($currentProviderIndex + 1) % count($this->services);
        return $keys[$nextProviderIndex];
    }
}
