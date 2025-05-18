<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="stat-card">
                    <div class="flex items-center">
                        <div class="stat-icon bg-sky-50">
                            <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="stat-label">Total Products</h4>
                            <div class="flex items-center">
                                <h2 class="stat-value">{{ \App\Models\Product::count() }}</h2>
                                <span class="text-green-500 text-sm font-semibold ml-2">Items</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center">
                        <div class="stat-icon bg-green-50">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="stat-label">Categories</h4>
                            <div class="flex items-center">
                                <h2 class="stat-value">{{ \App\Models\Category::count() }}</h2>
                                <span class="text-green-500 text-sm font-semibold ml-2">Total</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center">
                        <div class="stat-icon bg-purple-50">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="stat-label">Low Stock</h4>
                            <div class="flex items-center">
                                <h2 class="stat-value">{{ \App\Models\Product::where('quantity', '<', 10)->count() }}</h2>
                                <span class="text-red-500 text-sm font-semibold ml-2">Items</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center">
                        <div class="stat-icon bg-yellow-50">
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="stat-label">Total Value</h4>
                            <div class="flex items-center">
                                <h2 class="stat-value">${{ number_format(\App\Models\Product::sum(\DB::raw('price * quantity')), 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="card-header">Quick Actions</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('products.create') }}" class="flex items-center p-4 bg-sky-50 rounded-lg hover:bg-sky-100 transition duration-300">
                                <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="ml-3 font-medium text-sky-600">Add Product</span>
                            </a>
                            <a href="{{ route('categories.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-300">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="ml-3 font-medium text-green-600">Add Category</span>
                            </a>
                            <a href="{{ route('products.index') }}" class="flex items-center p-4 bg-sky-50 rounded-lg hover:bg-sky-100 transition duration-300">
                                <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span class="ml-3 font-medium text-sky-600">View Products</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-300">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <span class="ml-3 font-medium text-yellow-600">View Categories</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="card-header">Low Stock Alert</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach(\App\Models\Product::where('quantity', '<', 10)->take(4)->get() as $product)
                                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $product->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-red-600">{{ $product->quantity }} left</p>
                                        <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
