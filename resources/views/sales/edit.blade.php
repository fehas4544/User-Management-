<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Order Status: #{{ $sale->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <p><strong>Customer:</strong> {{ $sale->customer_name }}</p>
                        <p><strong>Total Amount:</strong> {{ __('messages.lkr') }} {{ number_format($sale->grand_total, 2) }}</p>
                        <p><strong>Date:</strong> {{ $sale->sale_date }}</p>
                    </div>

                    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4 max-w-xs">
                            <label class="block text-sm font-medium text-gray-700">Order Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <option value="Completed" {{ $sale->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Pending" {{ $sale->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Cancelled" {{ $sale->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="flex justify-start mt-6">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded font-bold">Update Status</button>
                            <a href="{{ route('sales.index') }}" class="ml-4 px-6 py-2 bg-gray-500 text-white rounded">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
