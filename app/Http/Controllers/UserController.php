<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user()
    {
        $users = User::all();
        $brands = Brand::all();

        return view('master-data.user.list')
                    ->with('brands', $brands)
                    ->with('users', $users);
    }

    public function showFormUser(Request $request)
    {
        $brands = Brand::all();

        if ($request->id) {
            $user = User::findOrFail($request->id);

            return view('master-data.user.edit')
                        ->with('user', $user)
                        ->with('brands', $brands);
        } else {
            return view('master-data.user.add')
                        ->with('brands', $brands);
        }
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'access_brand' => 'required',
            'active_hidden' => 'required'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'avatar' => '/assets/images/users/default.jpeg',
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'access_brand' => json_encode($request->access_brand),
                'active' => $request->active_hidden,
            ]);
        } catch (\exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function updateUser(Request $request)
    {
        $user = User::findOrFail($request->id);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'access_brand' => 'required',
            'active_hidden' => 'required',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'role' => $request->role,
                'active' => $request->active_hidden,
                'access_brand' => json_encode($request->access_brand),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->id);

        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }
}
