<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">{{ __('messages.sales') }}</p>
                    <p class="text-2xl font-bold">{{ __('messages.lkr') }} {{ number_format($stats['total_sales'], 2) }}</p>
                    <p class="text-xs text-gray-400">{{ $stats['sales_count'] }} {{ __('messages.transactions') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">{{ __('messages.products') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['products_count'] }}</p>
                    <p class="text-xs text-green-600">{{ __('messages.active_stock') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">{{ __('messages.customers') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['customers_count'] }}</p>
                    <p class="text-xs text-purple-600">{{ __('messages.registered') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">{{ __('messages.low_stock_warning') }}</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['low_stock']->count() }}</p>
                    <p class="text-xs text-red-400">{{ __('messages.items_below_10') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Sales -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-bold text-lg mb-4 border-b pb-2">{{ __('messages.recent_sales') }}</h3>
                        <div class="space-y-4">
                            @foreach($stats['recent_sales'] as $sale)
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-bold">{{ $sale->customer_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $sale->product_name }} x {{ $sale->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold">{{ __('messages.lkr') }} {{ number_format($sale->total, 2) }}</p>
                                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($sale->sale_date)->format('M d') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('sales.index') }}" class="block text-center mt-4 text-sm text-blue-600 hover:underline">{{ __('messages.view_all_sales') }}</a>
                    </div>
                </div>

                <!-- Stock Alert Table -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-bold text-lg mb-4 border-b pb-2 text-red-600">{{ __('messages.stock_alerts') }}</h3>
                        @if($stats['low_stock']->isEmpty())
                            <p class="text-gray-500 text-sm">{{ __('messages.stock_good') }}</p>
                        @else
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="text-gray-500 uppercase text-xs">
                                    <th class="py-2">{{ __('messages.product') }}</th>
                                    <th class="py-2 text-right">{{ __('messages.in_stock') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['low_stock'] as $p)
                                <tr class="border-b">
                                    <td class="py-2">{{ $p->name }}</td>
                                    <td class="py-2 text-right">
                                        <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-700 font-bold">
                                            {{ $p->stock_quantity }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
