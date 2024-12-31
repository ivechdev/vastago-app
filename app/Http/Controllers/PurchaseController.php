<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('items.product')->latest()->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::all();
        return view('purchases.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier' => 'required|string',
            'invoice_number' => 'required|string',
            'date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            $purchase = Purchase::create([
                'supplier' => $validated['supplier'],
                'invoice_number' => $validated['invoice_number'],
                'date' => $validated['date'],
                'status' => 'pending'
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                $total += $subtotal;

                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal
                ]);
            }

            $purchase->update(['total' => $total]);

            DB::commit();
            return redirect()->route('purchases.show', $purchase)->with('success', 'Compra registrada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar la compra')->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('items.product');
        return view('purchases.show', compact('purchase'));
    }

    public function complete(Purchase $purchase)
    {
        try {
            DB::beginTransaction();

            foreach ($purchase->items as $item) {
                $inventory = Inventory::firstOrCreate(
                    ['product_id' => $item->product_id],
                    ['quantity' => 0, 'minimum_stock' => 5, 'unit' => 'unidad']
                );

                $inventory->increment('quantity', $item->quantity);
            }

            $purchase->update(['status' => 'completed']);

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Compra completada y stock actualizado');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al completar la compra');
        }
    }

    public function cancel(Purchase $purchase)
    {
        if ($purchase->status === 'completed') {
            return redirect()->back()->with('error', 'No se puede cancelar una compra completada');
        }

        $purchase->update(['status' => 'cancelled']);
        return redirect()->route('purchases.index')->with('success', 'Compra cancelada exitosamente');
    }

    public function destroy(Purchase $purchase)
    {
        try {
            if ($purchase->status === 'completed') {
                return redirect()->back()->with('error', 'No se puede eliminar una compra completada');
            }

            DB::beginTransaction();

            // Eliminar los items de la compra primero
            $purchase->items()->delete();

            // Luego eliminar la compra
            $purchase->delete();

            DB::commit();
            return redirect()->route('purchases.index')
                ->with('success', 'Compra eliminada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar la compra');
        }
    }
}
