@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Productos</h2>
            <a href="{{ route('products.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nuevo Producto
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categoría
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precio
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock
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
                        @foreach($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $product->category === 'comida' ? 'bg-yellow-100 text-yellow-800' :
                                       ($product->category === 'bebestible' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800') }}">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($product->price, 0, ',', '.') }}</td>
<td class="px-6 py-4 whitespace-nowrap">
    @if($product->inventory)
        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold">
            @foreach($product->inventory as $inventoryItem)
                {{ $inventoryItem->pivot->quantity }} / {{ $inventoryItem->minimum_stock }} {{ $inventoryItem->unit }}<br>
            @endforeach
        </span>
    @else
        <span class="text-gray-400">Sin stock</span>
    @endif
</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('products.update', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="available" value="{{ $product->available ? '0' : '1' }}"
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $product->available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->available ? 'Disponible' : 'No disponible' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('products.edit', $product) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                <form action="{{ route('products.destroy', $product) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        Eliminar
                                    </button>
                                </form>
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
