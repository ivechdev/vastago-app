@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold">Orden #{{ $order->id }}</h2>
                        <p class="text-gray-600">Mesa {{ $order->table->number }}</p>
                    </div>
                    <span class="badge {{ $order->status_badge_class }}">
                        {{ $order->status_text }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium mb-2">Detalles</h3>
                        <p class="text-gray-600">Mesero: {{ $order->user->name }}</p>
                        <p class="text-gray-600">Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    {{ $item->product->name }}
                                    @if($item->notes)
                                        <p class="text-sm text-gray-500">{{ $item->notes }}</p>
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-bold">Total:</td>
                                <td class="font-bold">${{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <a href="{{ route('orders.index') }}" class="btn-secondary">
                        Volver
                    </a>

                    <a href="{{ route('orders.print', $order) }}"
                        class="btn-primary"
                        target="_blank">
                        Imprimir
                    </a>

                    @if($order->status === 'pending')
                        <form action="{{ route('orders.complete', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-success"
                                onclick="return confirm('¿Estás seguro de completar esta orden?')">
                                Completar Orden
                            </button>
                        </form>

                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-danger"
                                onclick="return confirm('¿Estás seguro de cancelar esta orden?')">
                                Cancelar Orden
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
