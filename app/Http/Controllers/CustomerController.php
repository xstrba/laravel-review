<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {

        return Customer::all();

    }

    public function show(Customer $customer) {

        return $customer->load('groups');

    }

    public function store() {

        $validator =  Validator::make(request()->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'name' => 'string|max:255',
        ]);
    
        if($validator->fails()){
            return response([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }
        
    
        $customer = new Customer;
        $customer->first_name = request('first_name');
        $customer->last_name = request('last_name');
        $customer->email = request('email');
        
        if($customer->save() && request('groups')) {
            $customer->syncGroups(array_column(request('groups'), 'name'));
            $customer->load('groups');
        }
        
        return $customer;

    }

    public function update(Customer $customer) {

        $validator =  Validator::make(request()->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'name' => 'string|max:255',
        ]);
    
        if($validator->fails()){
            return response([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }

        $customer->first_name = request('first_name');
        $customer->last_name = request('last_name');
        $customer->email = request('email');

        $success = $customer->save();
        
        if($success && request('groups')) {
            $customer->syncGroups(array_column(request('groups'), 'name'));
            $customer->load('groups');
        }

        return [
            'success' => $success
        ];

    }

    public function destroy(Customer $customer) {

        $success = $customer->delete();

        return [
            'success' => $success
        ];

    }
}
