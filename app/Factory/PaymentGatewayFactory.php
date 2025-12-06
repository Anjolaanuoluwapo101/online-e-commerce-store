<?php

namespace App\Factory;

use App\Services\PayStackService;

class PaymentGatewayFactory
{
    public static function createGateway(string $gatewayType)
    {
        switch ($gatewayType) {
            case 'Paystack':
                // Instantiate the specific service it wraps
                $paystackService = new PayStackService(); 
                // Return the specific Adapter
                return $paystackService;

            default:
                throw new \InvalidArgumentException("Unknown payment gateway type: $gatewayType");
        }
    }
}
