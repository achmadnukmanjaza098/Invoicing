<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {
        $categorys = Category::get();

        return view('master-data.category.list')->with('categorys', $categorys);
    }

    public function showFormCategory(Request $request)
    {
        if ($request->id) {
            $category = Category::findOrFail($request->id);

            return view('master-data.category.edit')
                        ->with('category', $category);
        } else {
            return view('master-data.category.add');
        }
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'active_hidden' => 'required',
        ]);

        try {
            $category = Category::create([
                'name' => $request->name,
                'active' => $request->active_hidden,
            ]);
        } catch (\exception $e) {
            \Log::debug($e);
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function updateCategory(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $request->validate([
            'name' => 'required',
            'active_hidden' => 'required',
        ]);

        try {
            $category->update([
                'name' => $request->name,
                'active' => $request->active_hidden,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::findOrFail($request->id);

        try {
            $category->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 500);
        }

        return redirect()->back()->with('success', 200);
    }
}
