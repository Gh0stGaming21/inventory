<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get inventory dashboard data for charts and analytics
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInventoryDashboardData()
    {
        // Get category data with product counts and values
        $categories = Category::select('id', 'name')
            ->withCount('products as product_count')
            ->withSum('products as total_quantity', 'quantity')
            ->get()
            ->map(function ($category) {
                // Calculate total value for each category
                $totalValue = Product::where('category_id', $category->id)
                    ->select(DB::raw('SUM(price * quantity) as total_value'))
                    ->first()
                    ->total_value ?? 0;
                
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'product_count' => $category->product_count,
                    'total_quantity' => $category->total_quantity ?? 0,
                    'total_value' => round($totalValue, 2)
                ];
            });
        
        // Get inventory health metrics
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('quantity', '<', 10)->count();
        $outOfStockProducts = Product::where('quantity', '<=', 0)->count();
        $healthyProducts = $totalProducts - $lowStockProducts;
        
        // Calculate inventory health score
        $healthScore = $totalProducts > 0 
            ? 100 - (($lowStockProducts + $outOfStockProducts * 2) / $totalProducts * 100) 
            : 100;
        $healthScore = max(0, min(100, $healthScore)); // Keep between 0-100
        
        // Get total inventory value
        $totalValue = Product::select(DB::raw('SUM(price * quantity) as total'))
            ->first()
            ->total ?? 0;
        
        return response()->json([
            'categories' => $categories,
            'metrics' => [
                'total_products' => $totalProducts,
                'healthy_products' => $healthyProducts,
                'low_stock_products' => $lowStockProducts - $outOfStockProducts,
                'out_of_stock_products' => $outOfStockProducts,
                'health_score' => round($healthScore, 1),
                'total_value' => round($totalValue, 2)
            ]
        ]);
    }
}
