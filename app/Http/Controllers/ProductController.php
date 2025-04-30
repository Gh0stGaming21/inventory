<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->has('sort')) {
            $sortField = $request->get('sort');
            $sortDirection = $request->get('direction', 'asc');
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(10)->withQueryString();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('products', 'name')
                ],
                'description' => 'required|string|min:10',
                'price' => 'required|numeric|min:0.01|regex:/^\\d+(\\.\\d{1,2})?$/',
                'quantity' => 'required|integer|min:0|max:99999',
                'category_id' => 'required|exists:categories,id',
                'sku' => 'nullable|string|max:50|unique:products,sku',
                'minimum_stock' => 'nullable|integer|min:0|max:99999'
            ], [
                'price.regex' => 'The price must have at most 2 decimal places.',
                'name.unique' => 'This product name already exists.',
                'description.min' => 'The description must be at least 10 characters.',
                'quantity.max' => 'The quantity cannot exceed 99,999 units.'
            ]);

            DB::beginTransaction();
            
            $product = Product::create($validated);
            
            // If stock is below minimum, trigger low stock alert
            if ($product->quantity <= ($product->minimum_stock ?? 0)) {
                // You can implement low stock notification here
                session()->flash('warning', 'Product created but stock level is below minimum threshold.');
            }
            
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product created successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create product. Please try again.');
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('products', 'name')->ignore($product->id)
                ],
                'description' => 'required|string|min:10',
                'price' => 'required|numeric|min:0.01|regex:/^\\d+(\\.\\d{1,2})?$/',
                'quantity' => 'required|integer|min:0|max:99999',
                'category_id' => 'required|exists:categories,id',
                'sku' => ['nullable', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product->id)],
                'minimum_stock' => 'nullable|integer|min:0|max:99999'
            ]);

            DB::beginTransaction();
            
            $oldQuantity = $product->quantity;
            $product->update($validated);
            
            // Track quantity changes
            if ($validated['quantity'] !== $oldQuantity) {
                // You can implement stock movement tracking here
                $movement = $validated['quantity'] - $oldQuantity;
                $message = $movement > 0 ? 'Stock increased by ' : 'Stock decreased by ';
                session()->flash('info', $message . abs($movement) . ' units.');
            }
            
            // Check minimum stock level
            if ($validated['quantity'] <= ($validated['minimum_stock'] ?? 0)) {
                session()->flash('warning', 'Product updated but stock level is below minimum threshold.');
            }
            
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product updated successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete product. Please try again.');
        }
    }
}
