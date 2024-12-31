<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with('product')->get();
        return view('inventory.index', compact('inventories'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'unit' => 'required|string'
        ]);

        $inventory->update($validated);
        $inventory = Inventory::create($validated);
        $inventory->updateStockStatus();
        return redirect()->route('inventory.index')->with('success', 'Inventario actualizado exitosamente');
    }

    public function adjustStock(Request $request, Inventory $inventory)
    {
        $request->validate([
            'adjustment' => 'required|numeric',
        ]);

        $inventory->quantity += $request->adjustment;
        $inventory->updateStockStatus();
        $inventory->save();

        return redirect()->route('inventory.index')->with('success', 'Stock ajustado exitosamente');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'unit' => 'required|string'
        ]);

        Inventory::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'minimum_stock' => $request->minimum_stock,
            'unit' => $request->unit
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventario creado exitosamente');
    }
}
