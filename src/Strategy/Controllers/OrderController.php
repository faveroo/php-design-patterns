<?php

namespace Patterns\Strategy\Controllers;

use Patterns\Strategy\Contracts\PaymentMethod;
use Patterns\Strategy\Factories\PaymentFactory;
use Patterns\Strategy\Models\Order;

class OrderController
{
    /**
     * Handle POST requests.
     * 
     * @param string $url
     * @param array $data
     * @throws \Exception
     * @return void
     */
    public function post(string $url, array $data): void
    {
        echo "Controller: POST request to $url with " . json_encode($data);

        $path = parse_url($url, PHP_URL_PATH);

        if (preg_match('#^/orders?$#', $path, $matches)) {
            $this->postNewOrder($data);
        } else {
            echo "Controller: 404 page\n";
        }
    }

    public function get(string $url): void
    {
        echo "Controller: GET request to $url\n";

        $path = parse_url($url, PHP_URL_PATH);
        $query = parse_url($url, PHP_URL_QUERY);
        
        if ($query) {
            parse_str($query, $data);
        }

        if (preg_match('#^/orders?$#', $path, $matches)) {
            $this->getAllOrders();
        } elseif (preg_match('#^/order/([0-9]+?)/payment/([a-z]+?)(/return)?$#', $path, $matches)) {
            $order = Order::get($matches[1]);   

            $paymentMethod = PaymentFactory::getPaymentMethod($matches[2]);

            if (!isset($matches[3])) {
                $this->getPayment($paymentMethod, $order);
            } else {
                $this->getPaymentReturn($paymentMethod, $order, $data);
            }
        } else {
            echo "Controller: 404 page\n";
        }
    }
    public function postNewOrder(array $data): void
    {
        $order = new Order($data);
        echo "Controller: Created the order #{$order->id}.\n";
    }

    public function getAllOrders(): void
    {
        echo "Controller: Here's all orders:\n";
        foreach(Order::get() as $order) {
            echo json_encode($order, JSON_PRETTY_PRINT) . "\n";
        }
    }

    public function getPayment(PaymentMethod $method, Order $order): void
    {
        $form = $method->getPaymentForm($order);
        echo "Controller: here's the payment form:\n";
        echo $form . "\n";
    }

    public function getPaymentReturn(PaymentMethod $method, Order $order, array $data): void
    {
        try {
            if ($method->validateReturn($order, $data)) {
                echo "Controller: Thanks for your order!\n";
                $order->complete();
            }
        } catch (\Exception $e) {
            echo "Controller: got an exception (" . $e->getMessage() . ")\n";
        }
    }
}