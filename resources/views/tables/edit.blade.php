@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Editar Mesa</h2>

            <form action="{{ route('tables.update', $table) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre y Número de Mesa</label>
                        <input type="text" name="number" value="{{ old('number', $table->number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Capacidad</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $table->capacity) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="available" {{ old('status', $table->status) == 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="occupied" {{ old('status', $table->status) == 'occupied' ? 'selected' : '' }}>Ocupada</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <a href="{{ route('tables.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancelar</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar Mesa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
