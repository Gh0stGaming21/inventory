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
                    {{ __('Create Product') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 bg-red-50 text-red-700 p-4 rounded-lg">
                    <div class="font-medium">Please fix the following errors:</div>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('products.store') }}" method="POST" class="space-y-6" id="productForm">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                    <input type="text" name="name" id="name" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('name') }}" required>
                                    <p class="mt-1 text-sm text-gray-500">Enter a unique product name</p>
                                </div>

                                <div>
                                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" id="sku" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('sku') }}" maxlength="50">
                                    <p class="mt-1 text-sm text-gray-500">Optional unique identifier for the product</p>
                                </div>

                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category_id" id="category_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    required>{{ old('description') }}</textarea>
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
                                        value="{{ old('price') }}" required>
                                </div>
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Current Stock</label>
                                <input type="number" name="quantity" id="quantity" min="0" max="99999" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    value="{{ old('quantity') }}" required>
                            </div>

                            <div>
                                <label for="minimum_stock" class="block text-sm font-medium text-gray-700">Minimum Stock Level</label>
                                <input type="number" name="minimum_stock" id="minimum_stock" min="0" max="99999" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    value="{{ old('minimum_stock') }}">
                                <p class="mt-1 text-sm text-gray-500">Alert when stock falls below this level</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                            <a href="{{ route('products.index') }}" 
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize form validation
            const productValidator = new FormValidator('productForm', {
                validateOnInput: true,
                validateOnBlur: true,
                validateOnSubmit: true
            });
            
            // Add validation rules for each field
            productValidator
                .addField('name', ValidationRules.validateProductName, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                })
                .addField('description', ValidationRules.validateDescription, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                })
                .addField('price', ValidationRules.validatePrice, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                })
                .addField('quantity', ValidationRules.validateQuantity, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                })
                .addField('category_id', (value) => {
                    return value ? null : 'Please select a category';
                }, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                })
                .addField('sku', ValidationRules.validateSku, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                })
                .addField('minimum_stock', (value) => {
                    const quantity = document.getElementById('quantity').value;
                    return ValidationRules.validateMinimumStock(value, quantity);
                }, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                });

            // Real-time validation for minimum stock when quantity changes
            document.getElementById('quantity').addEventListener('input', function() {
                productValidator.validateField('minimum_stock');
            });

            // Format price to have at most 2 decimal places
            const priceInput = document.getElementById('price');
            priceInput.addEventListener('blur', function() {
                const value = priceInput.value.trim();
                if (value && !isNaN(parseFloat(value))) {
                    priceInput.value = parseFloat(value).toFixed(2);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
