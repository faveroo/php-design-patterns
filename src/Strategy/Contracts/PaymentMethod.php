<?php 

namespace Patterns\Strategy\Contracts;

use Patterns\Strategy\Models\Order;

interface PaymentMethod
{
    public function getPaymentForm(Order $order): string;

    public function validateReturn(Order $order, array $data): bool;
}