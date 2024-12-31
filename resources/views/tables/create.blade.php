@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Crear Sector</h2>

            <form action="{{ route('tables.store') }}" method="POST">
                @csrf
                <div id="tables-container" class="space-y-6">
                    <div class="table-entry">
                        <label class="block text-sm font-medium text-gray-700">Nombre y Número de Mesa</label>
                        <input type="text" name="tables[0][number]" value="{{ old('tables.0.number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

                        <label class="block text-sm font-medium text-gray-700">Capacidad</label>
                        <input type="number" name="tables[0][capacity]" value="{{ old('tables.0.capacity', 4) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="tables[0][status]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="available" {{ old('tables.0.status') == 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="occupied" {{ old('tables.0.status') == 'occupied' ? 'selected' : '' }}>Ocupada</option>
                        </select>
                    </div>
                </div>

                <button type="button" id="add-table" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Agregar Otra Mesa
                </button>

                <div class="flex justify-end space-x-2 mt-4">
                    <a href="{{ route('tables.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancelar</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear Mesas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let itemCount = 1; // Comenzar desde 1 para las nuevas mesas

    document.getElementById('add-table').addEventListener('click', function() {
        const container = document.getElementById('tables-container');
        const newEntry = `
            <div class="table-entry">
                <label class="block text-sm font-medium text-gray-700">Número de Mesa</label>
                <input type="text" name="tables[${itemCount}][number]" value="{{ old('tables.${itemCount}.number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

                <label class="block text-sm font-medium text-gray-700">Capacidad</label>
                <input type="number" name="tables[${itemCount}][capacity]" value="{{ old('tables.${itemCount}.capacity', 4) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

                <label class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="tables[${itemCount}][status]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="available">Disponible</option>
                    <option value="occupied">Ocupada</option>
                </select>

                <button type="button" onclick="removeTable(${itemCount})" class="mt-2 text-red-600 hover:text-red-800">Eliminar</button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newEntry);
        itemCount++;
    });

    function removeTable(index) {
        const entries = document.querySelectorAll('.table-entry');
        if (entries.length > 1) {
            entries[index].remove();
        }
    }
</script>
@endsection
