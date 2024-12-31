@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6">Órdenes Activas</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($orders as $order)
            <div class="card">
                <div class="card-header">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Mesa {{ $order->table->number }}</h3>
                        <span class="badge {{ $order->status_badge_class }}">
                            {{ $order->status_text }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-700">Detalles</h4>
                            <p class="text-sm text-gray-600">Mesero: {{ $order->user->name }}</p>
                            <p class="text-sm text-gray-600">Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-700">Items</h4>
                            <ul class="mt-2 space-y-2">
                                @foreach($order->items as $item)
                                <li class="text-sm">
                                    {{ $item->quantity }}x {{ $item->product->name }}
                                    <span class="float-right">${{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="pt-4 border-t">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Total</span>
                                <span class="text-xl font-bold">${{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('orders.show', $order) }}" class="btn-secondary">
                                Ver Detalles
                            </a>

                            @if($order->status === 'pending')
                                <form action="{{ route('orders.complete', $order) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-success"
                                        onclick="return confirm('¿Estás seguro de completar esta orden?')">
                                        Completar
                                    </button>
                                </form>

                                <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-danger"
                                        onclick="return confirm('¿Estás seguro de cancelar esta orden?')">
                                        Cancelar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
