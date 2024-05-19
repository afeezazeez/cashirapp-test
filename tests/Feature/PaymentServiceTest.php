<?php

namespace Tests\Feature;

use App\Exceptions\ClientErrorException;
use App\Interfaces\PaymentGatewayInterface;
use App\PaymentProvider\PaymentGatewayFactory;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    public function testSwitchingPaymentGateways()
    {
        $this->withoutExceptionHandling();
        Log::shouldReceive('error')->times(2);

        // Mock the PaymentGatewayFactory
        $paymentGatewayFactoryMock = Mockery::mock(PaymentGatewayFactory::class)->makePartial();
        $paymentGatewayFactoryMock->currentProvider = 'flutterwave'; // Initial provider

        $paymentGatewayFactoryMock->shouldReceive('getProvider')
            ->once()
            ->andThrow(new ClientErrorException); // No specific message
        $paymentGatewayFactoryMock->shouldReceive('hasNextProvider')->once()->andReturn(true);
        $paymentGatewayFactoryMock->shouldReceive('setNextProvider')->once()->andReturnUsing(function () use ($paymentGatewayFactoryMock) {
            $paymentGatewayFactoryMock->currentProvider = 'paystack'; // Next provider
        });
        $paymentGatewayFactoryMock->shouldReceive('getProvider')
            ->once()
            ->andReturn(new class implements PaymentGatewayInterface {
                public function fetchBanks()
                {
                    return [
                        ['name' => 'Bank A', 'code' => '123'],
                        ['name' => 'Bank B', 'code' => '456'],
                    ];
                }
                public function resolveBankAccountNumber(array $data)
                {
                    return [
                        'account_number' => '0123456789',
                        'account_name' => 'John Doe',
                        'bank_id' => 1,
                    ];
                }
            });
        $paymentGatewayFactoryMock->shouldReceive('hasNextProvider')->andReturn(false);

        // Partially mock the PaymentService to use the mocked factory
        $paymentService = Mockery::mock(PaymentService::class)->makePartial();

        // Use reflection to set the protected paymentGatewayFactory property
        $reflectionClass = new \ReflectionClass($paymentService);
        $reflectionProperty = $reflectionClass->getProperty('paymentGatewayFactory');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($paymentService, $paymentGatewayFactoryMock);

        // Call the method under test
        $result = $paymentService->fetchBanks();

        // Verify the results
        $this->assertIsArray($result);
        foreach ($result as $bank) {
            $this->assertArrayHasKey('name', $bank);
            $this->assertArrayHasKey('code', $bank);
        }
    }


    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
