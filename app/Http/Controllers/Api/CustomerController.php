<?php

namespace App\Http\Controllers\Api;

use App\Filters\CustomerFilter;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Exception;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function store(CustomerRequest $request, Customer $customer)
    {
        try {
            $customer->name = $request->input('name');
            $customer->mobile = $request->input('mobile');
            $customer->email = $request->input('email');
            $customer->country_id = $request->input('country');
            $customer->active = $request->input('active');

            $customer->save();
            return response(200);
        } catch (Exception $exception) {
            return response(500);
        }
    }

    public function index(CustomerFilter $filters): JsonResponse
    {
        $customers = Customer::with(['Country'])->filter($filters)->get();

        foreach ($customers as $customer) {
            $customer['country'] = $customer->country;
        }

        return response()->json($customers);
    }
}
