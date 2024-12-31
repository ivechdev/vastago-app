<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'table', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->get();
        return view('orders.index', compact('orders'));
    }

    public function create(Request $request, $table_id)
    {
        $table = Table::findOrFail($table_id);
        if ($table->status !== 'occupied') {
            return redirect()->route('tables.index')
                ->with('error', 'La mesa debe estar ocupada para crear una orden');
        }

        $products = Product::where('available', true)->get();
        return view('orders.create', compact('table', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'table_id' => $validated['table_id'],
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total' => 0
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                    'notes' => $item['notes'] ?? null
                ]);
            }

            $order->update(['total' => $total]);

            DB::commit();
            return redirect()->route('orders.show', $order)
                ->with('success', 'Orden creada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear la orden')
                ->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'table', 'user']);
        return view('orders.show', compact('order'));
    }

    public function complete(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Solo se pueden completar órdenes pendientes');
        }

        $order->update(['status' => 'completed']);

        // Si la mesa no tiene más órdenes pendientes, liberarla
        if (!$order->table->current_order) {
            $order->table->update(['status' => 'available']);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Orden completada exitosamente');
    }

    public function cancel(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Solo se pueden cancelar órdenes pendientes');
        }

        $order->update(['status' => 'cancelled']);

        // Si la mesa no tiene más órdenes pendientes, liberarla
        if (!$order->table->current_order) {
            $order->table->update(['status' => 'available']);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Orden cancelada exitosamente');
    }

    public function print(Order $order)
    {
        $order->load(['items.product', 'table', 'user']);
        return view('orders.print', compact('order'));
    }
}
