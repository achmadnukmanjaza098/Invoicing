<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customer()
    {
        $customers = Customer::all();

        return view('customer.list')
                        ->with('customers', $customers);
    }

    public function showFormCustomer(Request $request)
    {
        if ($request->id) {
            $customer = Customer::findOrFail($request->id);

            return view('customer.edit')
                        ->with('customer', $customer);
        } else {
            return view('customer.add');
        }
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:customers,name',
            'email' => 'required',
            'no_hp' => [
                'required',
                'regex:/^[+0-9]+$/',
            ],
            'active_hidden' => 'required',
        ]);

        try {
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'active' => $request->active_hidden,
            ]);
        } catch (\exception $e) {
            \Log::debug($e);
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function updateCustomer(Request $request)
    {
        $customer = Customer::findOrFail($request->id);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'no_hp' => [
                'required',
                'regex:/^[+0-9]+$/',
            ],
            'active_hidden' => 'required',
        ]);

        try {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'active' => $request->active_hidden,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function deleteCustomer(Request $request)
    {
        $customer = Customer::findOrFail($request->id);

        try {
            $customer->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }
}
