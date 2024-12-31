@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Mesas</h2>
            <a href="{{ route('tables.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nueva Mesa</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($tables as $table)
            <div class="bg-white shadow-md rounded-lg p-4 {{ $table->status === 'available' ? 'bg-green-50' : 'bg-red-50' }}">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold">Mesa {{ $table->number }}</h3>
                    <span class="badge {{ $table->status === 'available' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $table->status === 'available' ? 'Disponible' : 'Ocupada' }}
                    </span>
                </div>
                <p class="text-gray-600">Capacidad: {{ $table->capacity }} personas</p>
                <div class="mt-4">
                    <a href="{{ route('tables.show', $table) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                    <a href="{{ route('tables.edit', $table) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                    <form action="{{ route('tables.destroy', $table) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $tables->links() }}
        </div>
    </div>
</div>
@endsection
