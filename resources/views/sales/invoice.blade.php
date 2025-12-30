<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order #{{ $sale->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg border border-gray-200" id="printableInvoice">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-3xl font-black text-blue-600 uppercase tracking-tighter">{{ __('messages.invoice') }}</h1>
                        <p class="text-xs text-gray-500 mt-1 font-mono">{{ __('messages.order_number') }}: {{ $sale->order_number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-xl text-gray-800">Sales Management System</p>
                        <p class="text-sm text-gray-600">Colombo, Sri Lanka</p>
                        <p class="text-sm text-gray-600">Phone: +94 11 123 4567</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 mb-8 border-t border-b py-6 bg-gray-50 px-4">
                    <div>
                        <p class="text-gray-400 uppercase text-[10px] font-black mb-1">{{ __('messages.customer_name') }}</p>
                        <p class="font-bold text-lg text-blue-900">{{ $sale->customer_name }}</p>
                        <p class="text-sm text-gray-700">{{ $sale->customer->phone ?? 'No Phone' }}</p>
                        <p class="text-sm text-gray-700">{{ $sale->customer->address ?? '' }}</p>
                    </div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="mb-1"><span class="text-gray-400 uppercase text-[10px] font-black">{{ __('messages.date') }}:</span> <span class="text-sm text-gray-800">{{ $sale->sale_date }}</span></p>
                        <p><span class="text-gray-400 uppercase text-[10px] font-black">{{ __('messages.status') }}:</span> <span class="px-2 py-0.5 rounded text-[10px] bg-green-100 text-green-700 font-bold uppercase">{{ $sale->status }}</span></p>
                    </div>
                </div>

                <table class="w-full mb-8 border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left text-xs uppercase tracking-widest">
                            <th class="px-4 py-3 rounded-tl">{{ __('messages.product_name') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('messages.price') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('messages.quantity') }}</th>
                            <th class="px-4 py-3 text-right rounded-tr">{{ __('messages.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 font-medium text-gray-800">{{ $item->product_name }}</td>
                            <td class="px-4 py-4 text-right text-gray-600">{{ __('messages.lkr') }} {{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-4 text-right font-bold">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 text-right font-bold text-blue-900">{{ __('messages.lkr') }} {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end">
                    <div class="w-72 space-y-3">
                        <div class="flex justify-between text-sm py-1 border-b">
                            <span class="text-gray-500">{{ __('messages.subtotal') }}:</span>
                            <span class="font-medium text-gray-800">{{ __('messages.lkr') }} {{ number_format($sale->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm py-1 border-b">
                            <span class="text-gray-500 text-xs">{{ __('messages.tax') }} (+):</span>
                            <span class="text-gray-800">{{ __('messages.lkr') }} {{ number_format($sale->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm py-1 border-b">
                            <span class="text-gray-500 text-xs">{{ __('messages.discount') }} (-):</span>
                            <span class="text-red-600">{{ __('messages.lkr') }} {{ number_format($sale->discount, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-t-2 border-blue-600 bg-blue-50 px-3 rounded">
                            <span class="font-black text-blue-600 uppercase text-xs self-center">{{ __('messages.grand_total') }}:</span>
                            <span class="font-black text-2xl text-blue-900 font-mono">{{ __('messages.lkr') }} {{ number_format($sale->grand_total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center border-t border-dashed pt-8">
                    @if($sale->notes)
                    <div class="mb-8 text-left bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Order Notes:</p>
                        <p class="text-sm text-gray-700 italic">"{{ $sale->notes }}"</p>
                    </div>
                    @endif
                    <p class="text-gray-800 font-bold italic">Thank you for Choosing us!</p>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase">This is a computer generated invoice</p>
                </div>
            </div>

            <div class="mt-10 flex justify-center space-x-4 no-print">
                <button onclick="window.print()" class="px-8 py-3 bg-blue-600 text-white font-black rounded-xl shadow-lg hover:bg-blue-700 transition-all active:scale-95 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    {{ __('messages.print') }} {{ __('messages.invoice') }}
                </button>
                <a href="{{ route('sales.index') }}" class="px-8 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl border hover:bg-gray-200 transition-all">
                    {{ __('messages.back') }}
                </a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; background: white !important; }
            #printableInvoice, #printableInvoice * { visibility: visible; }
            #printableInvoice { position: absolute; left: 0; top: 0; width: 100%; border: none; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>

    <script>
        // Auto-print when page loads if redirected from a successful sale
        window.onload = function() {
            if (window.location.search.includes('print=true') || {{ session('success') ? 'true' : 'false' }}) {
                setTimeout(() => {
                    window.print();
                }, 500);
            }
        };
    </script>
</x-app-layout>
