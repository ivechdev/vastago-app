@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Compras</h2>
            <a href="{{ route('purchases.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nueva Compra
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Proveedor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                N° Factura
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($purchases as $purchase)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $purchase->date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $purchase->supplier }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $purchase->invoice_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ number_format($purchase->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $purchase->status === 'completed' ? 'bg-green-100 text-green-800' :
                                       ($purchase->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('purchases.show', $purchase) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>

                                @if($purchase->status === 'pending')
                                    <form action="{{ route('purchases.complete', $purchase) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-green-600 hover:text-green-900 mr-3"
                                            onclick="return confirm('¿Confirmar recepción de productos?')">
                                            Completar
                                        </button>
                                    </form>

                                    <form action="{{ route('purchases.cancel', $purchase) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('¿Estás seguro de cancelar esta compra?')">
                                            Cancelar
                                        </button>
                                    </form>

                                    @if($purchase->status !== 'completed')
                                        <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('¿Estás seguro de eliminar esta compra?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
