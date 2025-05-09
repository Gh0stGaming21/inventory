<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('categories.index') }}" class="bg-gray-100 p-2 rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Category') }}
            </h2>
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
                    <form action="{{ route('categories.store') }}" method="POST" id="categoryForm">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="name" id="name" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {{ $errors->has('name') ? 'border-red-500' : '' }}" 
                                value="{{ old('name') }}" 
                                required>
                            <p class="mt-1 text-sm text-gray-500">Enter a unique category name (minimum 2 characters)</p>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" id="description" rows="3" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {{ $errors->has('description') ? 'border-red-500' : '' }}" 
                                required>{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Minimum 5 characters</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150">
                                Create Category
                            </button>
                            <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">Cancel</a>
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
            const categoryValidator = new FormValidator('categoryForm', {
                validateOnInput: true,
                validateOnBlur: true,
                validateOnSubmit: true
            });
            
            // Add validation rules for each field
            categoryValidator
                .addField('name', ValidationRules.validateCategoryName, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                })
                .addField('description', ValidationRules.validateDescription, {
                    errorClass: 'border-red-500',
                    errorMessageClass: 'text-red-500 text-sm mt-1'
                });
        });
    </script>
    @endpush
</x-app-layout>
