<?php


namespace Tests\Feature\Http\Controllers\Auth;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Class BankControllerTest
 * @package Tests\Feature\Http\Controllers\Auth
 */
class BankControllerTest extends TestCase
{

    /**
     * RefreshDatabase
     */
    use RefreshDatabase;

    /**
     * @return array
     */
    public function _provider_testDepositPointsDataProvider()
    {

        return [
            [
                'points' => '100',
                'description' => 'Test Deposit 1',
                'taxable' => true
            ],
            [
                'points' => '1',
                'description' => 'Test Deposit 2',
                'taxable' => false
            ],
            [
                'points' => '-999',
                'description' => 'Test Deposit 3',
                'taxable' => true
            ],
        ];

    }

    /**
     * @param string $points
     * @param string $description
     * @param bool $taxable
     * @dataProvider _provider_testDepositPointsDataProvider
     */
    public function testDepositPoints(string $points, string $description, bool $taxable)
    {

        // Create Mock Request
        $mockRequest = \Mockery::mock(Request::class)->makePartial();
        $mockRequest->points = $points;
        $mockRequest->description = $description;
        $mockRequest->taxable = $taxable;

        // Create user
        $user = factory(\App\User::class)->create();

        // Create Mock BankController
        $mockBankController = \Mockery::mock('App\Http\Controllers\BankController')->makePartial();

        // Creat Mock BankService
        $mockBankService = \Mockery::mock('App\Services\BankService')->makePartial();

        // Mock the bank service method deposit()
        $mockBankService->shouldReceive('deposit')
            ->with($user, $mockRequest->points, $mockRequest->description, $mockRequest->taxable);

        // Expect that the bank service should call send
        $mockBankService->shouldReceive('send');

        // set the bank service to mock bank service
        $mockBankController->_bankService = $mockBankService;

        $response = $mockBankController->deposit($user, $mockRequest);

        $this->assertEquals('true', $response->getContent());

    }
}
