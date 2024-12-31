@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Editar Orden #{{ $order->id }}</h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                       ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="mb-4">
                <p class="text-gray-600">Mesa: {{ $order->table->number }}</p>
                <p class="text-gray-600">Mesero: {{ $order->user->name }}</p>
                <p class="text-gray-600">Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <form action="{{ route('orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('orders.show', $order) }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
