<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="bg-gray-100 p-2 rounded-lg hover:bg-gray-200 transition duration-150">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Categories') }}
                </h2>
            </div>
            <a href="{{ route('categories.create') }}" 
                class="flex items-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Category
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div class="flex-1">
                    <form action="{{ route('categories.index') }}" method="GET" class="flex gap-4">
                        <div class="flex-1 max-w-xs">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 transition duration-150">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($categories as $category)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                                    <div class="text-sm text-gray-500">ID: #{{ $category->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-md">{{ $category->description }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $category->products_count }} products
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-3">
                                                <a href="{{ route('categories.edit', $category) }}" 
                                                    class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded-md hover:bg-blue-100 transition duration-150">
                                                    Edit
                                                </a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md hover:bg-red-100 transition duration-150"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
