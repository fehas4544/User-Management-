<x-app-layout>
    <!-- Premium UI: Added Tom Select for Searchable Dropdowns -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight flex items-center">
            <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            {{ __('messages.new_sale') }} (Sales Order & Billing)
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                        <p class="font-bold">Attention Required!</p>
                        <ul class="list-disc pl-5 text-sm mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="POST" id="saleForm" onsubmit="return validateStock()">
                        @csrf
                        <!-- Order Header -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10 bg-blue-50 p-6 rounded-xl border border-blue-100">
                            <div class="lg:col-span-2">
                                <label class="block text-xs font-black text-blue-900 uppercase tracking-widest mb-2">{{ __('messages.customer_name') }}</label>
                                <select name="customer_id" id="customer_select" class="mt-1 block w-full" required>
                                    <option value="">Search or Select Customer...</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->phone }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-blue-900 uppercase tracking-widest mb-2">Order Date</label>
                                <input type="date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500 font-medium" required>
                            </div>
                        </div>

                        <!-- Product Selection Table -->
                        <div class="mb-10">
                            <h3 class="text-xl font-black text-gray-800 mb-6 flex items-center uppercase tracking-tight">
                                <span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">1</span>
                                Order Details
                            </h3>
                            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                                <table class="w-full text-sm text-left" id="itemsTable">
                                    <thead class="bg-gray-800 text-white uppercase text-[10px] font-black tracking-widest">
                                        <tr>
                                            <th class="px-6 py-4">Search & Select Product</th>
                                            <th class="px-6 py-4 w-40 text-right">Price (LKR)</th>
                                            <th class="px-6 py-4 w-28 text-center">Quantity</th>
                                            <th class="px-6 py-4 w-40 text-right">Subtotal</th>
                                            <th class="px-6 py-4 w-16 text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <!-- Row Template -->
                                        <tr class="item-row bg-white hover:bg-gray-50 transition-colors">
                                            <td class="p-4">
                                                <select name="items[0][product_id]" class="product-select w-full" required>
                                                    <option value="">Type Product Name or Code...</option>
                                                    @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                        data-price="{{ $product->price }}" 
                                                        data-stock="{{ $product->stock_quantity }}" 
                                                        data-code="{{ $product->code }}" 
                                                        data-name="{{ $product->name }}">
                                                        {{ $product->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="stock-info hidden mt-1 text-[10px] flex justify-between">
                                                    <span class="text-gray-500 SKU-label">SKU: ---</span>
                                                    <span class="stock-status font-bold"></span>
                                                </div>
                                                <span class="stock-warning text-xs text-red-600 font-bold hidden flex items-center mt-2">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg>
                                                    Exceeds Stock!
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                <input type="text" class="price-input w-full rounded-lg border-gray-100 bg-gray-50 text-right font-mono font-bold text-blue-900 shadow-inner" readonly>
                                            </td>
                                            <td class="p-4">
                                                <input type="number" name="items[0][quantity]" min="1" value="1" class="qty-input w-full rounded-lg border-gray-200 text-center font-bold focus:ring-blue-500 focus:border-blue-500" required oninput="calculateRow(this)">
                                            </td>
                                            <td class="p-4">
                                                <input type="text" class="subtotal-input w-full rounded-lg border-gray-100 bg-gray-50 text-right font-mono font-black text-gray-800 shadow-inner" readonly>
                                            </td>
                                            <td class="p-4 text-center">
                                                <button type="button" class="text-gray-300 hover:text-red-600 transition-all transform hover:scale-125 remove-row-btn" onclick="removeRow(this)">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="mt-6 px-10 py-3 bg-gray-800 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-700 hover:shadow-lg transition-all flex items-center transform active:scale-95 shadow-md" onclick="addRow()">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Add Another Item
                            </button>
                        </div>

                        <!-- Summary & Billing -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mt-16 border-t border-gray-100 pt-12">
                            <div>
                                <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Billing Note
                                </h3>
                                    <textarea name="notes" placeholder="Add any special instructions or order notes here..." class="w-full rounded-2xl border-gray-200 h-32 text-sm placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('notes') }}</textarea>
                            </div>
                            
                            <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100 shadow-inner">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center text-gray-500 font-bold uppercase text-xs tracking-widest">
                                        <span>Items Subtotal:</span>
                                        <span id="itemsSubtotalDisplay" class="font-mono text-lg text-gray-800">LKR 0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-black text-blue-900 uppercase tracking-widest flex items-center">
                                            Tax (+)
                                            <span class="text-[10px] ml-1 lowercase font-normal italic">(e.g. VAT/NBT)</span>
                                        </span>
                                        <input type="number" name="tax" value="0" step="0.01" class="w-40 rounded-xl border-gray-200 text-right font-bold text-blue-900 focus:ring-blue-500 focus:border-blue-500 shadow-sm" oninput="calculateFinal()">
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-black text-red-900 uppercase tracking-widest">Discount (-)</span>
                                        <input type="number" name="discount" value="0" step="0.01" class="w-40 rounded-xl border-gray-200 text-right font-bold text-red-600 focus:ring-red-500 focus:border-red-500 shadow-sm" oninput="calculateFinal()">
                                    </div>
                                    <div class="pt-6 border-t border-gray-200 mt-6 bg-white p-6 rounded-2xl shadow-sm">
                                        <div class="flex justify-between items-center">
                                            <span class="font-black text-gray-400 uppercase text-xs tracking-[0.3em] self-center">Grand Total Due</span>
                                            <div class="text-right">
                                                <span id="finalTotalDisplay" class="font-black text-4xl text-blue-700 font-mono tracking-tighter">LKR 0.00</span>
                                                <p class="text-[10px] text-gray-400 mt-1 uppercase">Tax Inclusive Summary</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center mt-12 space-x-6">
                            <a href="{{ route('sales.index') }}" class="px-10 py-4 bg-gray-100 text-gray-500 font-black rounded-2xl border-2 border-transparent hover:bg-gray-200 hover:text-gray-700 transition-all uppercase text-xs tracking-widest">
                                Cancel Order
                            </a>
                            <button type="submit" class="px-16 py-5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-black rounded-2xl shadow-xl hover:shadow-blue-500/20 transition-all hover:-translate-y-1 transform active:scale-95 uppercase text-sm tracking-widest flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Complete & Generate Bill
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Perfected Script Logic -->
    <script>
        let rowCount = 1;
        
        // Initialize Search for existing rows
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#customer_select', { create: false, sortField: { field: "text", order: "asc" } });
            initProductSelect('.product-select');
        });

        function initProductSelect(selector) {
            document.querySelectorAll(selector).forEach(el => {
                if (el.tomselect) return;
                
                const ts = new TomSelect(el, {
                    valueField: 'value',
                    labelField: 'text',
                    searchField: ['text', 'code'],
                    render: {
                        option: function(data, escape) {
                            return `<div class="py-2 px-3 border-b border-gray-50 search-opt">
                                        <div class="font-bold text-gray-800">${escape(data.text)}</div>
                                    </div>`;
                        },
                        item: function(data, escape) {
                            return `<div>${escape(data.text)}</div>`;
                        }
                    },
                    onChange: function(value) {
                        const row = el.closest('.item-row');
                        if (value) {
                            // Find the option in the original select element to get data attributes
                            const opt = el.querySelector(`option[value="${value}"]`);
                            const data = {
                                price: opt.dataset.price,
                                stock: opt.dataset.stock,
                                code: opt.dataset.code,
                                name: opt.dataset.name
                            };
                            populateRowData(row, data);
                        } else {
                            clearRowData(row);
                        }
                    }
                });
            });
        }

        function addRow() {
            const tbody = document.querySelector('#itemsTable tbody');
            const newRow = tbody.querySelector('.item-row').cloneNode(true);
            
            // Clean the clone by removing Tom Select UI
            const tsWrapper = newRow.querySelector('.ts-wrapper');
            if (tsWrapper) tsWrapper.remove(); 

            let select = newRow.querySelector('.product-select');
            select.name = `items[${rowCount}][product_id]`;
            select.id = `product_select_${rowCount}`;
            select.classList.remove('tomselected');
            select.style.display = 'block'; 
            select.value = '';
            
            // Reset numerical fields
            newRow.querySelector('.qty-input').name = `items[${rowCount}][quantity]`;
            newRow.querySelector('.qty-input').value = 1;
            newRow.querySelector('.price-input').value = '';
            newRow.querySelector('.subtotal-input').value = '';
            
            // Reset warning/info states
            newRow.querySelector('.stock-warning').classList.add('hidden');
            newRow.querySelector('.stock-info').classList.add('hidden');
            newRow.querySelector('.qty-input').classList.remove('border-red-500', 'bg-red-50', 'text-red-700');
            
            tbody.appendChild(newRow);
            
            // Re-initialize search for the specific new select
            initProductSelect(`#product_select_${rowCount}`);
            
            rowCount++;
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                const tr = btn.closest('tr');
                const selectElement = tr.querySelector('.product-select');
                if (selectElement && selectElement.tomselect) {
                    selectElement.tomselect.destroy();
                }
                tr.remove();
                calculateFinal();
            } else {
                alert('An order must have at least one product.');
            }
        }

        function populateRowData(row, data) {
            const price = parseFloat(data.price) || 0;
            const stock = parseInt(data.stock) || 0;
            const code = data.code || '---';

            // Automatic Price Population
            row.querySelector('.price-input').value = price.toFixed(2);
            
            // SKU and Stock Info
            const skuLabel = row.querySelector('.SKU-label');
            const stockStatus = row.querySelector('.stock-status');
            const stockInfo = row.querySelector('.stock-info');

            if (skuLabel) skuLabel.innerText = `SKU: ${code}`;
            if (stockStatus) {
                stockStatus.innerText = `Available: ${stock}`;
                stockStatus.className = `stock-status font-bold ${stock < 10 ? 'text-red-600' : 'text-green-600'}`;
            }
            if (stockInfo) stockInfo.classList.remove('hidden');
            
            // Auto calculate subtotal with current quantity
            calculateRow(row.querySelector('.qty-input'));
        }

        function clearRowData(row) {
            const stockInfo = row.querySelector('.stock-info');
            if (stockInfo) stockInfo.classList.add('hidden');
            
            row.querySelector('.price-input').value = '';
            row.querySelector('.subtotal-input').value = '';
            
            const warning = row.querySelector('.stock-warning');
            if (warning) warning.classList.add('hidden');
            
            row.querySelector('.qty-input').classList.remove('border-red-500', 'bg-red-50', 'text-red-700');
            calculateFinal();
        }

        function calculateRow(qtyInput) {
            const row = qtyInput.closest('.item-row');
            const select = row.querySelector('.product-select');
            
            if (select.tomselect && select.value) {
                const data = select.tomselect.options[select.value];
                const stock = parseInt(data.stock);
                const qty = parseInt(qtyInput.value) || 0;
                const price = parseFloat(data.price);
                
                // Real-time stock warning
                const warning = row.querySelector('.stock-warning');
                if (qty > stock && stock !== -1) {
                    warning.classList.remove('hidden');
                    qtyInput.classList.add('border-red-500', 'bg-red-50', 'text-red-700');
                } else {
                    warning.classList.add('hidden');
                    qtyInput.classList.remove('border-red-500', 'bg-red-50', 'text-red-700');
                }

                row.querySelector('.subtotal-input').value = (price * qty).toFixed(2);
            } else {
                row.querySelector('.subtotal-input').value = '';
            }
            calculateFinal();
        }

        function calculateFinal() {
            let total = 0;
            document.querySelectorAll('.subtotal-input').forEach(input => {
                if (input.value) total += parseFloat(input.value);
            });

            document.getElementById('itemsSubtotalDisplay').innerText = `LKR ${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;

            const taxInput = document.querySelector('input[name="tax"]');
            const discountInput = document.querySelector('input[name="discount"]');
            
            const tax = taxInput ? (parseFloat(taxInput.value) || 0) : 0;
            const discount = discountInput ? (parseFloat(discountInput.value) || 0) : 0;
            const final = (total + tax) - discount;

            document.getElementById('finalTotalDisplay').innerText = `LKR ${final.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        }

        function validateStock() {
            let isValid = true;
            document.querySelectorAll('.item-row').forEach(row => {
                const select = row.querySelector('.product-select');
                const qtyInput = row.querySelector('.qty-input');
                
                if (select.tomselect && select.value) {
                    const data = select.tomselect.options[select.value];
                    const stock = parseInt(data.stock);
                    const qty = parseInt(qtyInput.value) || 0;
                    
                    if (qty > stock && stock !== -1) {
                        isValid = false;
                    }
                    if (qty <= 0) {
                        isValid = false;
                        alert('Quantity must be greater than 0');
                    }
                } else {
                    isValid = false; 
                }
            });

            if (!isValid) {
                alert('Submission failed: One or more rows are invalid or exceed available stock.');
            }
            return isValid;
        }
    </script>

    <style>
        /* Tom Select Styling Fixes for Tailwind */
        .ts-control { border-radius: 0.75rem !important; padding: 0.75rem !important; border-color: #e5e7eb !important; font-weight: 500 !important; }
        .ts-control input { font-size: 0.875rem !important; }
        .ts-dropdown { border-radius: 0.75rem !important; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important; margin-top: 5px !important; }
        .ts-wrapper.single .ts-control { background-image: none !important; }
    </style>
</x-app-layout>
