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
            'phone' => ['required', 'regex:/^[0-9]+$/'],
            'address' => 'required',
            'logo' => 'required',
            'active_hidden' => 'required',
            'detail_rekening' => 'required',
            'detail_rekening.*.rekening' => 'required',
        ]);

        $file = $request->file('logo');
        $fileName = $file->getClientOriginalName();
        $destinationPath = public_path('/assets/uploads/logo');
        $file->move($destinationPath, $fileName);

        try {
            $brand = Brand::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $fileName,
                'active' => $request->active_hidden,
                'no_rekening' => json_encode($request->detail_rekening),
            ]);
        } catch (\exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function updateBrand(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $fileName = $brand->image;

        $request->validate([
            'name' => 'required',
            'phone' => ['required', 'regex:/^[0-9]+$/'],
            'address' => 'required',
            'active_hidden' => 'required',
            'detail_rekening' => 'required',
            'detail_rekening.*.rekening' => 'required',
        ]);

        if ($request->file('logo')) {
            $file = $request->file('logo');
            unlink(public_path('/assets/uploads/logo/' . $fileName));
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path('/assets/uploads/logo');
            $file->move($destinationPath, $fileName);
        }

        try {
            $brand->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $fileName,
                'active' => $request->active_hidden,
                'no_rekening' => array_values($request->detail_rekening),
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
