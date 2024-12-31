@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6">Inventario</h2>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Actual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Mínimo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($inventories as $inventory)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $inventory->product->name ?? 'Sin producto' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->minimum_stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->unit }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $inventory->quantity <= $inventory->minimum_stock ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $inventory->quantity <= $inventory->minimum_stock ? 'Stock Bajo' : 'OK' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" onclick="openAdjustModal({{ $inventory->id }})" class="text-indigo-600 hover:text-indigo-900">
                                    Ajustar Stock
                                </button>
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
