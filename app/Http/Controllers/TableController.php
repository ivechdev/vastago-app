<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Order;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::paginate(10);
        return view('tables.index', compact('tables'));
    }

    public function show(Table $table)
    {
        $table->load('current_order.items.product');
        return view('tables.show', compact('table'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tables.*.number' => 'required|string|unique:tables,text',
            'tables.*.capacity' => 'required|integer|min:1',
            'tables.*.status' => 'required|in:available,occupied',
        ]);

        foreach ($validated['tables'] as $tableData) {
            Table::create([
                'number' => $tableData['number'],
                'capacity' => $tableData['capacity'],
                'status' => $tableData['status'],
            ]);

            $order = Order::create([
                'total' => $validated['total'],
                'tip' => $validated['tip'],
            ]);

            $table->current_order()->associate($order);
            $table->save();
        }

        return redirect()->route('tables.index')
            ->with('success', 'Mesas y orden creada exitosamente');
    }

    public function occupy(Table $table)
    {
        if ($table->status !== 'available') {
            return redirect()->back()
                ->with('error', 'La mesa ya está ocupada');
        }

        $table->update(['status' => 'occupied']);
        return redirect()->route('orders.create', $table->id);
    }

    public function release(Table $table)
    {
        if ($table->status !== 'occupied') {
            return redirect()->back()
                ->with('error', 'La mesa no está ocupada');
        }

        if ($table->current_order) {
            return redirect()->back()
                ->with('error', 'No se puede liberar una mesa con una orden pendiente');
        }

        $table->update(['status' => 'available']);
        return redirect()->route('tables.index')
            ->with('success', 'Mesa liberada exitosamente');
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Mesa eliminada exitosamente');
    }
}
