<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    public function fetchBanks();
    public function resolveBankAccountNumber(array $data);
}
