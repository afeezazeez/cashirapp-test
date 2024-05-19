<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_the_api_returns_transactions(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/transactions');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'success',
                    'data' => [
                        'current_page',
                        'data' => [
                            '*' => [
                                'uuid',
                                'reference',
                                'amount',
                                'status',
                                'type',
                                'date',
                                'description',
                            ]
                        ],
                        'first_page_url',
                        'from',
                        'last_page',
                        'last_page_url',
                        'links' => [
                            '*' => [
                                'url',
                                'label',
                                'active',
                            ]
                        ],
                        'next_page_url',
                        'path',
                        'per_page',
                        'prev_page_url',
                        'to',
                        'total',
                    ],
                    'message',
            ]);
    }
}
