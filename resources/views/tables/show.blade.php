@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Detalles de la Mesa {{ $table->number }}</h2>

            <div class="space-y-4">
                <p><strong>Número de Mesa:</strong> {{ $table->number }}</p>
                <p><strong>Capacidad:</strong> {{ $table->capacity }} personas</p>
                <p><strong>Estado:</strong> {{ $table->status }}</p>
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('tables.edit', $table) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar Mesa</a>
                <form action="{{ route('tables.destroy', $table) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro de eliminar esta mesa?')">Eliminar Mesa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
