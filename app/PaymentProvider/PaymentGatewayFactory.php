<?php

namespace App\PaymentProvider;

use App\Exceptions\ClientErrorException;
use App\PaymentProvider\Flutterwave\FlutterwavePaymentGateway;
use App\PaymentProvider\Paystack\PaystackPaymentGateway;
use Illuminate\Support\Facades\Log;


class PaymentGatewayFactory
{
    private static $services = [
        'flutterwave' => FlutterwavePaymentGateway::class,
        'paystack' => PaystackPaymentGateway::class,
    ];

    private static $currentProvider = 'flutterwave';

    /**
     */
    public static function getProvider()
    {
        $serviceClass = self::$services[self::$currentProvider];

        return new $serviceClass();
    }

    public static function hasNextProvider(): bool
    {
        $keys = array_keys(self::$services);
        $currentProviderIndex = array_search(self::$currentProvider, $keys);
        return $currentProviderIndex < count(self::$services)-1;
    }

    public static function setNextProvider()
    {
        $keys = array_keys(self::$services);
        $currentProviderIndex = array_search(self::$currentProvider, $keys);
        self::$currentProvider = $keys[$currentProviderIndex+1];
    }

    public static function getNextProvider()
    {
        $keys = array_keys(self::$services);
        $currentProviderIndex = array_search(self::$currentProvider, $keys);
        Log::info("current provider index: ".$currentProviderIndex);
        return $keys[$currentProviderIndex+1];
    }
}
