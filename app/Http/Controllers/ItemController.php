<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function item()
    {
        $items = Item::join('brands', 'brands.id', '=', 'items.brand_id')
                            ->select('items.id as id', 'brands.name as brand', 'code', 'items.name as name', 'size', 'qty')
                            ->get();

        return view('master-data.item.list')->with('items', $items);
    }

    public function showFormItem(Request $request)
    {
        $brands = Brand::all();

        if ($request->id) {
            $item = Item::findOrFail($request->id);

            return view('master-data.item.edit')
                        ->with('item', $item)
                        ->with('brands', $brands);
        } else {
            return view('master-data.item.add')
                        ->with('brands', $brands);
        }
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'size' => 'required|alpha',
            'qty' => 'required|numeric',
            'active_hidden' => 'required',
        ]);

        try {
            $item = Item::create([
                'brand_id' => $request->brand_id,
                'code' => $request->code,
                'name' => $request->name,
                'size' => $request->size,
                'qty' => $request->qty,
                'active' => $request->active_hidden,
            ]);
        } catch (\exception $e) {
            \Log::debug($e);
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function updateItem(Request $request)
    {
        $item = Item::findOrFail($request->id);

        $request->validate([
            'brand_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'size' => 'required|alpha',
            'qty' => 'required|numeric',
            'active_hidden' => 'required',
        ]);

        try {
            $item->update([
                'brand_id' => $request->brand_id,
                'code' => $request->code,
                'name' => $request->name,
                'size' => $request->size,
                'qty' => $request->qty,
                'active' => $request->active_hidden,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function deleteItem(Request $request)
    {
        $item = Item::findOrFail($request->id);

        try {
            $item->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }
}
