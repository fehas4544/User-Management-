<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('messages.products') }}</h3>
                        @can('create-products')
                        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-500">
                            {{ __('messages.add_product') }}
                        </a>
                        @endcan
                    </div>
                    
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">{{ __('messages.code') }}</th>
                                <th class="px-6 py-3">{{ __('messages.name') }}</th>
                                <th class="px-6 py-3">{{ __('messages.price') }}</th>
                                <th class="px-6 py-3">{{ __('messages.stock') }}</th>
                                <th class="px-6 py-3">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4">{{ $product->code }}</td>
                                <td class="px-6 py-4">{{ $product->name }}</td>
                                <td class="px-6 py-4">{{ __('messages.lkr') }} {{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded {{ $product->stock_quantity < 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex space-x-2">
                                    @can('edit-products')
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900">{{ __('messages.edit') }}</a>
                                    @endcan
                                    @can('delete-products')
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.are_you_sure_delete') }}')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-900">{{ __('messages.delete') }}</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $products->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
