<?php


namespace App\Services;


use App\User;
use Exception;

/**
 * Class BankService
 * @package App\Services
 */
class BankService
{
    /**
     * @param User $user
     * @param string $points
     * @param string $description
     * @param bool $taxable
     * @return bool
     * @throws Exception
     */
    public function depositPoints(User $user, $points, $description, $taxable)
    {
        $this->send();
        return true;
    }

    /**
     * @throws Exception
     */
    public function send()
    {
        throw new Exception('Bank is down');
    }
}
