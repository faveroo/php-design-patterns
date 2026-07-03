<?php

namespace Patterns\Strategy\Models;

class Order
{
    private static $orders = [];
    public int $id;
    public string $status;
    public string $email;
    public float $total;
    public string $product;

    public static function get(?int $orderId = null) {
        if ($orderId === null) {
            return static::$orders;
        } else {
            return static::$orders[$orderId];
        }
    }

    public function __construct(array $attributes) {
        $this->id = count(static::$orders);

        $this->status = "new";
        
        foreach($attributes as $key => $value) {
            $this->{$key} = $value;
        }

        static::$orders[$this->id] = $this;
    }

    public function complete(): void
    {
        $this->status = "completed";
        echo "Order: #{$this->id} is now {$this->status}";
    }
}