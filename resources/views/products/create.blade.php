<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Product</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text" name="name" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Code (SKU)</label>
                            <input type="text" name="code" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Price (LKR)</label>
                            <input type="number" step="0.01" name="price" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="w-full rounded-md border-gray-300" required>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
