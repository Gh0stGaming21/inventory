<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            
            // The request is already validated via CategoryRequest
            $validated = $request->validated();
            Category::create($validated);
            
            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create category. Please try again.');
        }
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            DB::beginTransaction();
            
            // The request is already validated via CategoryRequest
            $validated = $request->validated();
            $category->update($validated);
            
            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update category. Please try again.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();
            
            if ($category->products()->count() > 0) {
                DB::rollBack();
                return redirect()->route('categories.index')
                    ->with('error', 'Cannot delete category with associated products');
            }

            $category->delete();
            
            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete category. Please try again.');
        }
    }
}
