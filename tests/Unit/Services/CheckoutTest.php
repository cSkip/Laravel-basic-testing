<?php


namespace Tests\Unit;


use App\Services\Checkout;
use Exception;
use Tests\TestCase;

/**
 * Class CheckoutTest
 * @package Tests\Unit
 */
class CheckoutTest extends TestCase
{

    protected $checkout;

    public function setUp(): void
    {
        $this->checkout = new Checkout();
    }

    /**
     * DataProvider for testCalculateTotal
     *
     * @return array
     */
    public function _provider_testCalculateTotal()
    {
        return [
            // Cash totals
            ['Cash', 100, 104.5],
            ['Cash', 6, 1.1],

            // CreditCard totals
            ['CreditCard', 100, 110.00],
            ['CreditCard', 1, 1.1]
        ];
    }

    /**
     * @covers       \App\Services\Checkout::calculateTotal()
     *
     * @param string $paymentMethod
     * @param int $purchaseAmount
     * @param float $expectedTotal
     *
     * @dataProvider _provider_testCalculateTotal
     */
    public function testCalculateTotal(string $paymentMethod, int $purchaseAmount, float $expectedTotal)
    {

        $message = 'Testing total for ' . $paymentMethod;
        $this->assertEquals(
            $expectedTotal,
            $this->checkout->calculateTotal($paymentMethod, $purchaseAmount),
            $message
        );
    }

    public function _provider_testCalculateTotalThrowsException()
    {
        return [
            // Invalid payment methods :: message(Payment Method Invalid)
            ['Pay Pal', 100, 'Payment Method Invalid'],
            ['BitCoin', 50, 'Payment Method Invalid'],

            // Invalid totals Cash :: message(Total must be greater than 0)
            ['Cash', -100, 'Total must be greater than 0'],
            ['Cash', 0, 'Total must be greater than 0'],
            ['Cash', 1, 'Total must be greater than 0'],
            ['Cash', 2, 'Total must be greater than 0'],
            ['Cash', 3, 'Total must be greater than 0'],
            ['Cash', 4, 'Total must be greater than 0'],
            ['Cash', 5, 'Total must be greater than 0'],

            // Invalid totals CreditCard :: message(Total must be greater than 0)
            ['CreditCard', -100, 'Total must be greater than 0'],
            ['CreditCard', 0, 'Total must be greater than 0'],
        ];
    }

    /**
     * @covers       \App\Services\Checkout::calculateTotal()
     *
     * @param string $paymentMethod
     * @param int $purchaseAmount
     * @param string $exceptionMessage
     *
     * @dataProvider _provider_testCalculateTotalThrowsException
     */
    public function testCalculateTotalThrowsException(string $paymentMethod, int $purchaseAmount, string $exceptionMessage)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage($exceptionMessage);
        $this->checkout->calculateTotal($paymentMethod, $purchaseAmount);
    }
}
