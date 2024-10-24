<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // get all customers
    public function index()
    {
        // getting all customers
        $customers = Customer::all();

        // validate if list is empty
        if ($customers->isEmpty()) {
            // make error message
            $data = [
                'message' => "Whoops, it seems there are no records for now",
                'status' => 200
            ];

            // return error
            return response()->json($data, 200);
        }

        // make success message
        return response()->json($customers, 200);
    }

    // create a customer
    public function store(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0', 
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Whoops, something went wrong creating a customer',
                'errors' => $validator->errors(),
            ], 400);
        }

        // create the customer
        $customer = Customer::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'age' => $request->age,
        ]);

        // return success message
        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer,
        ], 201); // HTTP 201 Created
    }

    // find an specific customer
    public function show($name) 
    {
        // find the customer
        $customers = Customer::where('name', $name)->get();

        // validate if list is empty
        if ($customers->isEmpty()) {
            // error message
            $data = [
                'message' => 'Whoops, customers not found with name: '.$name,
                'status' => 404
            ];

            // return data
            return response()->json($data, 404);
        }

        // success message
        $data = [
            'message' => 'Customers found!',
            'customers' => $customers,
            'status' => 200 
        ];

        // return data
        return response()->json($data, 200);
    }

    // find an specific customer
    public function showById($id) 
    {
        // find the customer
        $customer = Customer::find($id);

        // validate if list is empty
        if (!$customer) {
            // error message
            $data = [
                'message' => 'Whoops, customer not found with id: '.$id,
                'status' => 404
            ];

            // return data
            return response()->json($data, 404);
        }

        // success message
        $data = [
            'message' => 'Customer found!',
            'customer' => $customer,
            'status' => 200 
        ];

        // return data
        return response()->json($data, 200);
    }

    // delete a customer by id
    public function destroy($id)
    {
        // find the customer
        $customer = Customer::find($id);

        // validate customer is found
        if (!$customer) {
            // error message
            $data = [
                'message' => 'Whoops, customer not found with id '.$id,
                'status' => 404
            ];

            // return data
            return response()->json($data, 404);
        }

        // delete customer if found
        $customer->delete();

        // success message
        $data = [
            'message' => 'We will miss you customer '.$id,
            'customer' => $customer,
            'status' => 200
        ];

        // return data
        return response()->json($data, 200);

    }

    // update a customer by id
    public function update(Request $request, $id)
    {
        // find the customer
        $customer = Customer::find($id);

        // validate customer was found
        if (!$customer) {
            // error message
            $data = [
                'message' => 'Whoops, customer not found with id: '.$id,
                'status' => 404
            ];

            // return data
            return response()->json($data, 404);
        }

        // validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0', 
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Whoops, something went wrong updating the customer with id: '.$id,
                'errors' => $validator->errors(),
            ], 400);
        }

        // set old values with new values
        $customer->name = $request->name;
        $customer->last_name = $request->last_name;
        $customer->age = $request->age;
        $customer->save();

        // success message
        $data = [
            'message' => 'Customer with id: '.$id.' has changed his look.',
            'customer' => $customer,
            'status' => 200
        ];

        // return data
        return response()->json($data, 200);
    }

    // partial update of a customer
    public function partialUpdate(Request $request, $id)
    {
        // find the customer
        $customer = Customer::find($id);

        // validate customer was found
        if (!$customer) {
            // error message
            $data = [
                'message' => 'Whoops, customer not found with id: '.$id,
                'status' => 404
            ];

            // return data
            return response()->json($data, 404);
        }

        // validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'age' => 'integer|min:0', 
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Whoops, something went wrong updating the customer with id: '.$id,
                'errors' => $validator->errors(),
            ], 400);
        }

        // set old values with new values (if they exist)
        if ($request->has('name')) {
            $customer->name = $request->name;
        }
        if ($request->has('last_name')) {
            $customer->last_name = $request->last_name;
        }
        if ($request->has('age')) {
            $customer->age = $request->age;
        }
        $customer->save();


        // success message
        $data = [
            'message' => 'Customer with id: '.$id.' has changed his look.',
            'customer' => $customer,
            'status' => 200
        ];

        // return data
        return response()->json($data, 200);
    }
}
