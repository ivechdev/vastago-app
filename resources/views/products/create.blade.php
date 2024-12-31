@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Crear Nuevo Producto</h2>

            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Información del Producto</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio</label>
                            <input type="number" name="price" value="{{ old('price') }}" step="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categoría</label>
                            <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="comida" {{ old('category') == 'comida' ? 'selected' : '' }}>Comida</option>
                                <option value="ingrediente" {{ old('category') == 'ingrediente' ? 'selected' : '' }}>Ingrediente</option>
                                <option value="verdura" {{ old('category') == 'verdura' ? 'selected' : '' }}>Verdura</option>
                                <option value="fruta" {{ old('category') == 'fruta' ? 'selected' : '' }}>Fruta</option>
                                <option value="bebestible" {{ old('category') == 'bebestible' ? 'selected' : '' }}>Bebida</option>
                                <option value="jugo" {{ old('category') == 'jugo' ? 'selected' : '' }}>Jugo</option>
                                <option value="barra" {{ old('category') == 'barra' ? 'selected' : '' }}>Barra</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="available" value="1" {{ old('available', true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm">
                            <label class="ml-2 block text-sm text-gray-900">Disponible</label>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Información de Inventario</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock Inicial</label>
                            <input type="number" name="inventory[quantity]" value="{{ old('inventory.quantity', 0) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                            <input type="number" name="inventory[minimum_stock]" value="{{ old('inventory.minimum_stock', 5) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unidad de Medida</label>
                            <select name="inventory[unit]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="unidad" {{ old('inventory.unit') == 'unidad' ? 'selected' : '' }}>Unidad</option>
                                <option value="kg" {{ old('inventory.unit') == 'kg' ? 'selected' : '' }}>Kilogramos</option>
                                <option value="caja" {{ old('inventory.unit') == 'lt' ? 'selected' : '' }}>Caja</option>
                                <option value="lt" {{ old('inventory.unit') == 'lt' ? 'selected' : '' }}>Litros</option>
                                <option value="gr" {{ old('inventory.unit') == 'lt' ? 'selected' : '' }}>Gramos</option>
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
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
