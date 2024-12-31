<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('inventory')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'available' => 'boolean',
            'inventory.quantity' => 'required|numeric|min:0',
            'inventory.minimum_stock' => 'required|numeric|min:0',
            'inventory.unit' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::create($validatedData);

            Inventory::create([
                'product_id' => $product->id,
                'name' => $validatedData['name'],
                'quantity' => $validatedData['inventory']['quantity'],
                'minimum_stock' => $validatedData['inventory']['minimum_stock'],
                'unit' => $validatedData['inventory']['unit'],
            ]);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear el producto: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Si solo se está actualizando la disponibilidad
        if ($request->has('available') && $request->keys() === ['_token', '_method', 'available']) {
            $product->update(['available' => $request->boolean('available')]);
            return redirect()->back()->with('success', 'Estado actualizado exitosamente');
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:comida,bebestible,postre,ingrediente,verdura,fruta,jugo,barra',
            'available' => 'boolean',
            'inventory.quantity' => 'required|numeric|min:0',
            'inventory.minimum_stock' => 'required|numeric|min:0',
            'inventory.unit' => 'required|in:unidad,caja,kg,gramos,lt'
        ]);

        try {
            DB::beginTransaction();

            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'category' => $validated['category'],
                'available' => $request->has('available')
            ]);

            $product->inventory()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity' => $validated['inventory']['quantity'],
                    'minimum_stock' => $validated['inventory']['minimum_stock'],
                    'unit' => $validated['inventory']['unit']
                ]
            );

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar el producto')->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el producto');
        }
    }
}
