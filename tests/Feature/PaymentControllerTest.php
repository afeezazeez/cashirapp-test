<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\PaymentController;
use App\Http\Requests\ResolveAccountRequest;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    public function test_banks_can_be_fetched()
    {
        $paymentServiceMock = Mockery::mock(PaymentService::class);
        $paymentServiceMock->shouldReceive('fetchBanks')->once()->andReturn([
            ['name' => 'Some Bank', 'code' => '123'],
            ['name' => 'Another Bank', 'code' => '456'],
        ]);

        $controller = new PaymentController($paymentServiceMock);
        $response = $controller->fetchBanks();
        $responseData = $response->getData(true);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('success', $responseData);
        $this->assertTrue($responseData['success']);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        foreach ($responseData['data'] as $bank) {
            $this->assertArrayHasKey('name', $bank);
            $this->assertArrayHasKey('code', $bank);
        }
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Success', $responseData['message']);
    }


    public function test_bank_account_can_be_resolved()
    {
        $paymentServiceMock = Mockery::mock(PaymentService::class);
        $paymentServiceMock->shouldReceive('resolveBankAccountNumber')->once()->andReturn([
            'account_number' => '1234567890',
            'account_name' => 'John Doe',
            'bank_id' => 1,
        ]);

        $requestMock = Mockery::mock(ResolveAccountRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn([
            'bank_code' => '001',
            'account_number' => '1234567890',
        ]);

        $controller = new PaymentController($paymentServiceMock);
        $response = $controller->resolveBankAccountNumber($requestMock);

        $responseData = $response->getData(true);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('success', $responseData);
        $this->assertTrue($responseData['success']);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('account_number', $responseData['data']);
        $this->assertArrayHasKey('account_name', $responseData['data']);
        $this->assertArrayHasKey('bank_id', $responseData['data']);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Success', $responseData['message']);
    }




    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
