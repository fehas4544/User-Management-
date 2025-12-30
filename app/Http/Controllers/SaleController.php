<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:view-sales|create-sales|edit-sales|delete-sales', ['only' => ['index','show']]);
         $this->middleware('permission:create-sales', ['only' => ['create','store']]);
         $this->middleware('permission:edit-sales', ['only' => ['edit','update']]);
         $this->middleware('permission:delete-sales', ['only' => ['destroy']]);
         $this->middleware('permission:view-invoices', ['only' => ['invoice']]);
    }

    public function index()
    {
        $sales = Sale::with(['customer', 'items'])->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = \App\Models\Customer::all();
        $products = \App\Models\Product::all();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                $customer = \App\Models\Customer::findOrFail($request->customer_id);
                
                $total = 0;
                $saleItems = [];

                foreach ($request->items as $itemData) {
                    $product = \App\Models\Product::findOrFail($itemData['product_id']);
                    
                    if ($product->stock_quantity < $itemData['quantity']) {
                        throw new \Exception('Insufficient stock for ' . $product->name . '. Only ' . $product->stock_quantity . ' left.');
                    }

                    $subtotal = $itemData['quantity'] * $product->price;
                    $total += $subtotal;

                    $saleItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $itemData['quantity'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ];

                    $product->decrement('stock_quantity', $itemData['quantity']);
                }

                $tax = $request->tax ?? 0;
                $discount = $request->discount ?? 0;
                $grandTotal = ($total + $tax) - $discount;

                $sale = Sale::create([
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'customer_id' => $request->customer_id,
                    'customer_name' => $customer->name,
                    'total' => $total,
                    'tax' => $tax,
                    'discount' => $discount,
                    'grand_total' => $grandTotal,
                    'sale_date' => $request->sale_date,
                    'status' => 'Completed',
                    'notes' => $request->notes,
                ]);

                foreach ($saleItems as $item) {
                    $sale->items()->create($item);
                }

                return redirect()->route('sales.invoice', $sale->id)->with('success', 'Sales Order & Billing completed successfully.');
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Sale $sale)
    {
        $customers = \App\Models\Customer::all();
        $products = \App\Models\Product::all();
        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate(['status' => 'required']);
        $sale->update(['status' => $request->status]);
        return redirect()->route('sales.index')->with('success', 'Order status updated.');
    }

    public function destroy(Sale $sale)
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }
            $sale->delete();
            return redirect()->route('sales.index')->with('success', 'Sale order deleted and stock reverted.');
        });
    }

    public function invoice(Sale $sale)
    {
        $sale->load(['customer', 'items']);
        return view('sales.invoice', compact('sale'));
    }
}
