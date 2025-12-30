<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.sales') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8">
                    @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-8 flex items-center shadow-sm" role="alert">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <div>
                            <span class="font-bold">{{ __('messages.save') }}!</span>
                            <span class="block sm:inline ml-1">{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('messages.sales') }}</h3>
                            <p class="text-sm text-gray-500 mt-1 font-medium italic">{{ __('messages.complete_order_history') }}</p>
                        </div>
                        @can('create-sales')
                        <a href="{{ route('sales.create') }}" class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-blue-200 hover:shadow-2xl hover:scale-[1.02] active:scale-95 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            {{ __('messages.new_sale') }}
                        </a>
                        @endcan
                    </div>
                    
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-white uppercase bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4 rounded-tl-lg">{{ __('messages.order_number') }}</th>
                                    <th scope="col" class="px-6 py-4">{{ __('messages.customer_name') }}</th>
                                    <th scope="col" class="px-6 py-4">{{ __('messages.products') }} & {{ __('messages.quantity') }}</th>
                                    <th scope="col" class="px-6 py-4 text-right">{{ __('messages.subtotal') }}</th>
                                    <th scope="col" class="px-6 py-4 text-center">{{ __('messages.tax') }}/{{ __('messages.discount') }}</th>
                                    <th scope="col" class="px-6 py-4 text-right">{{ __('messages.grand_total') }}</th>
                                    <th scope="col" class="px-6 py-4 text-center">{{ __('messages.status') }}</th>
                                    <th scope="col" class="px-6 py-4 rounded-tr-lg text-center">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                <tr class="bg-white border-b hover:bg-blue-50/30 transition-colors">
                                    <th scope="row" class="px-6 py-4 font-mono text-xs text-blue-600 font-black">
                                        {{ $sale->order_number }}
                                        <div class="text-[10px] text-gray-400 font-normal mt-1">
                                            {{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}
                                        </div>
                                    </th>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $sale->customer_name }}
                                        <div class="text-[10px] text-gray-400 font-normal">
                                            {{ $sale->customer->phone ?? '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @foreach($sale->items as $item)
                                            <div class="flex items-center justify-between text-[11px] bg-gray-50 px-2 py-1 rounded">
                                                <span class="font-bold text-gray-700">{{ $item->product_name }}</span>
                                                <span class="ml-2 text-blue-600 font-black">x{{ $item->quantity }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                        @if($sale->notes)
                                        <div class="mt-2 text-[10px] bg-yellow-50 text-yellow-700 px-2 py-1 rounded border border-yellow-100 italic truncate w-40" title="{{ $sale->notes }}">
                                            <span class="font-black">{{ __('messages.note') }}:</span> {{ $sale->notes }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-600 font-medium">
                                        {{ number_format($sale->total, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-col text-[10px]">
                                            <span class="text-green-600 font-bold">+{{ number_format($sale->tax, 2) }}</span>
                                            <span class="text-red-500 font-bold">-{{ number_format($sale->discount, 2) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-blue-900 text-base">
                                        <span class="text-[10px] font-normal text-gray-400 mr-1">{{ __('messages.lkr') }}</span>{{ number_format($sale->grand_total, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold {{ $sale->status === 'Completed' ? 'bg-green-100 text-green-800' : ($sale->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $sale->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @can('view-invoices')
                                            <a href="{{ route('sales.invoice', $sale->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm group" title="{{ __('messages.view_print_invoice') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                            </a>
                                            @endcan
                                            @can('delete-sales')
                                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete_sale') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" title="{{ __('messages.delete') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
