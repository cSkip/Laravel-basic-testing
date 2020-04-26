<?php

namespace App\Http\Controllers;

use App\Services\BankService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankController extends Controller
{

    public $_bankService;

    /**
     * BankController constructor.
     * @param BankService $bankService
     */
    public function __construct(BankService $bankService)
    {
        $this->_bankService = $bankService;
    }


    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function deposit(User $user, Request $request)
    {
        $result = $this->_bankService->depositPoints($user, $request->points, $request->description, $request->taxable);

        return response()->json($result);
    }
}
