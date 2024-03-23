<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function brand()
    {
        $brands = Brand::all();

        return view('master-data.brand.list')->with('brands', $brands);
    }

    public function showFormBrand(Request $request)
    {
        if ($request->id) {
            $brand = Brand::findOrFail($request->id);

            return view('master-data.brand.edit')
                        ->with('brand', $brand);
        } else {
            return view('master-data.brand.add');
        }
    }

    public function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $brand = Brand::create([
                'name' => $request->name,
            ]);
        } catch (\exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function updateBrand(Request $request)
    {
        $brand = Brand::findOrFail($request->id);

        $request->validate([
            'name' => 'required',
        ]);

        try {
            $brand->update([
                'name' => $request->name,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function deleteBrand(Request $request)
    {
        $brand = Brand::findOrFail($request->id);

        try {
            $brand->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }
}
