@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-semibold">Compra #{{ $purchase->id }}</h2>
                    <p class="text-gray-600">Fecha: {{ $purchase->date->format('d/m/Y') }}</p>
                    <p class="text-gray-600">Proveedor: {{ $purchase->supplier }}</p>
                    <p class="text-gray-600">N° Factura: {{ $purchase->invoice_number }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $purchase->status === 'completed' ? 'bg-green-100 text-green-800' :
                       ($purchase->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($purchase->status) }}
                </span>
            </div>

            <div class="border rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Unit.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($purchase->items as $item)
                        <tr>
                            <td class="px-6 py-4">{{ $item->product->name }}</td>
                            <td class="px-6 py-4">
                                {{ $item->quantity }}
                                {{ $item->product->inventory->first()->unit ?? 'unidad' }}
                            </td>
                            <td class="px-6 py-4">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                            <td class="px-6 py-4 font-bold">${{ number_format($purchase->total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('purchases.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Volver
                </a>

                @if($purchase->status === 'pending')
                    <form action="{{ route('purchases.complete', $purchase) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('¿Confirmar recepción de productos?')">
                            Completar Compra
                        </button>
                    </form>

                    <form action="{{ route('purchases.cancel', $purchase) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('¿Estás seguro de cancelar esta compra?')">
                            Cancelar Compra
                        </button>
                    </form>

                    @if($purchase->status !== 'completed')
                        <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn-danger"
                                onclick="return confirm('¿Estás seguro de eliminar esta compra?')">
                                Eliminar Compra
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
