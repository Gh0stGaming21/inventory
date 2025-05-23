<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('products.index') }}" class="bg-gray-100 p-2 rounded-lg hover:bg-gray-200 transition duration-150">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Product') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                    <input type="text" name="name" id="name" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('name', $product->name) }}" required>
                                    <p class="mt-1 text-sm text-gray-500">Enter a unique product name</p>
                                </div>

                                <div>
                                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" id="sku" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('sku', $product->sku) }}" maxlength="50">
                                    <p class="mt-1 text-sm text-gray-500">Optional unique identifier for the product</p>
                                </div>

                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category_id" id="category_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="8" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    required>{{ old('description', $product->description) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Minimum 10 characters</p>
                            </div>
                        </div>

                        <!-- Stock and Price Information -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="price" id="price" step="0.01" min="0.01" 
                                        class="block w-full pl-7 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                        value="{{ old('price', $product->price) }}" required>
                                </div>
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Current Stock</label>
                                <input type="number" name="quantity" id="quantity" min="0" max="99999" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    value="{{ old('quantity', $product->quantity) }}" required>
                            </div>

                            <div>
                                <label for="minimum_stock" class="block text-sm font-medium text-gray-700">Minimum Stock Level</label>
                                <input type="number" name="minimum_stock" id="minimum_stock" min="0" max="99999" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    value="{{ old('minimum_stock', $product->minimum_stock) }}">
                                <p class="mt-1 text-sm text-gray-500">Alert when stock falls below this level</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                                Update Product
                            </button>
                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Price validation
            const priceInput = document.getElementById('price');
            priceInput.addEventListener('input', function(e) {
                let value = e.target.value;
                if (value.includes('.')) {
                    let parts = value.split('.');
                    if (parts[1].length > 2) {
                        e.target.value = parseFloat(value).toFixed(2);
                    }
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const name = document.getElementById('name').value.trim();
                const description = document.getElementById('description').value.trim();
                const price = parseFloat(document.getElementById('price').value);
                const quantity = parseInt(document.getElementById('quantity').value);
                const category = document.getElementById('category_id').value;

                if (name.length < 1) {
                    isValid = false;
                    alert('Product name is required');
                }

                if (description.length < 10) {
                    isValid = false;
                    alert('Description must be at least 10 characters long');
                }

                if (isNaN(price) || price <= 0) {
                    isValid = false;
                    alert('Please enter a valid price');
                }

                if (isNaN(quantity) || quantity < 0) {
                    isValid = false;
                    alert('Please enter a valid quantity');
                }

                if (!category) {
                    isValid = false;
                    alert('Please select a category');
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
