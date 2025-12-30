<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product: {{ $product->name }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Code (SKU)</label>
                            <input type="text" name="code" value="{{ $product->code }}" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Price (LKR)</label>
                            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Stock Quantity</label>
                            <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" class="w-full rounded-md border-gray-300" required>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('products.index') }}" class="mr-4 px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
