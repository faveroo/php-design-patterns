<?php

namespace Patterns\Strategy\Factories;

use Patterns\Strategy\Contracts\PaymentMethod;
use Patterns\Strategy\PaymentMethods\CreditCardPayment;
use Patterns\Strategy\PaymentMethods\PayPalPayment;

class PaymentFactory
{
    public static function getPaymentMethod(string $id): PaymentMethod
    {
        switch ($id) {
            case "cc":
                return new CreditCardPayment();
            case "paypal": 
                return new PayPalPayment();
            default:
                throw new \Exception("Unknown Payment Method");
        }
    }
}