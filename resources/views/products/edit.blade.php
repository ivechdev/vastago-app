@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Editar Producto</h2>

            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Información del Producto</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" step="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categoría</label>
                            <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="comida" {{ old('category', $product->category) == 'comida' ? 'selected' : '' }}>Comida</option>
                                <option value="bebestible" {{ old('category', $product->category) == 'bebestible' ? 'selected' : '' }}>Bebestible</option>
                                <option value="postre" {{ old('category', $product->category) == 'postre' ? 'selected' : '' }}>Postre</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="available" value="1"
                                {{ old('available', $product->available) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm">
                            <label class="ml-2 block text-sm text-gray-900">Disponible</label>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Información de Inventario</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock Actual</label>
                            <input type="number" name="inventory[quantity]"
                                value="{{ old('inventory.quantity', $product->inventory->first()?->quantity ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                            <input type="number" name="inventory[minimum_stock]"
                                value="{{ old('inventory.minimum_stock', $product->inventory->first()?->minimum_stock ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unidad de Medida</label>
                            <select name="inventory[unit]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="unidad" {{ old('inventory.unit', $product->inventory->first()?->unit) == 'unidad' ? 'selected' : '' }}>Unidad</option>
                                <option value="kg" {{ old('inventory.unit', $product->inventory->first()?->unit) == 'kg' ? 'selected' : '' }}>Kilogramos</option>
                                <option value="lt" {{ old('inventory.unit', $product->inventory->first()?->unit) == 'lt' ? 'selected' : '' }}>Litros</option>
                                <option value="cajas" {{ old('inventory.unit', $product->inventory->first()?->unit) == 'cajas' ? 'selected' : '' }}>Cajas</option>
                                <option value="gramos" {{ old('inventory.unit', $product->inventory->first()?->unit) == 'gramos' ? 'selected' : '' }}>Gramos</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
