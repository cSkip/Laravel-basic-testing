<?php


namespace App\Services;


use Exception;

/**
 * Class Checkout
 * @package App\Services
 */
class Checkout
{

    const ALLOWED_PAYMENT_METHODS = ['Cash', 'CreditCard'];

    const CASH_DISCOUNT = 5.00;

    const TAX_PERCENTAGE = .10;

    /**
     *
     * @param string $paymentMethod
     * @param int $purchaseAmount
     * @return float $total
     * @throws Exception
     */
    public function calculateTotal(string $paymentMethod, int $purchaseAmount): float
    {
        $total = 0.00;

        if (!in_array($paymentMethod, self::ALLOWED_PAYMENT_METHODS, true)) {
            throw new Exception("Payment Method Invalid");
        }

        if ($paymentMethod === 'Cash') {
            $total = $purchaseAmount - self::CASH_DISCOUNT;
        } elseif ($paymentMethod === 'CreditCard') {
            $total = $purchaseAmount;
        }

        // Add tax
        $total += ($total * self::TAX_PERCENTAGE);

        if ($total <= 0) {
            throw new Exception('Total must be greater than 0');
        }

        return $total;
    }
}
