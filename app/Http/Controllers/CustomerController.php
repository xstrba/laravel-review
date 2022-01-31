<?php

namespace App\Http\Controllers;

use App\Actions\UpdateCustomerAction;
use App\Http\CustomerValidator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {

        return Customer::all();

    }

    public function show(Customer $customer)
    {

        return $customer->load('groups');

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique',
            'name' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }


        $customer = new Customer;
        $customer->first_name = request('first_name');
        $customer->last_name = request('last_name');
        $customer->email = request('email');

        if ($customer->save() && request('groups')) {
            $customer->syncGroups(array_column(request('groups'), 'name'));
            $customer->load('groups');
        }

        return $customer;

    }

    /**
     * @param \App\Models\Customer $customer
     * @param \App\Http\CustomerValidator $validator
     * @param \Illuminate\Http\Request $request
     * @param \App\Actions\UpdateCustomerAction $action
     * @param \Illuminate\Contracts\Routing\ResponseFactory $responseFactory
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(
        Customer $customer,
        CustomerValidator $validator,
        Request $request,
        UpdateCustomerAction $updateAction,
        ResponseFactory $responseFactory
    ): \Illuminate\Http\JsonResponse {

        $updateAction->run($customer, $validator->getValidatedData($request), $validator->getValidatedGroups($request));
        return $responseFactory->json($customer->toArray());

    }

    public function destroy(Customer $customer)
    {

        $success = $customer->delete();

        return [
            'success' => $success
        ];

    }
}
