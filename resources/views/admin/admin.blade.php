@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold">Panel de Control</h2>
            <img src="{{ asset('images/vastago_black.png') }}" alt="Restaurante Vastago" class="h-16">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Mesas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Mesas</h3>
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                            {{ \App\Models\Table::count() }} total
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">Gestión de mesas y órdenes</p>
                    <a href="{{ route('tables.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                        Ver Mesas
                    </a>
                </div>
            </div>

            <!-- Órdenes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Órdenes</h3>
                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                            {{ \App\Models\Order::where('status', 'pending')->count() }} pendientes
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">Control de órdenes y pedidos</p>
                    <a href="{{ route('orders.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-700 text-white font-bold rounded">
                        Ver Órdenes
                    </a>
                </div>
            </div>

            <!-- Productos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Productos</h3>
                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                            {{ \App\Models\Product::count() }} total
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">Gestión de productos y precios</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                        Ver Productos
                    </a>
                </div>
            </div>

            <!-- Inventario -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Inventario</h3>
                        <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800">
                            {{ \App\Models\Inventory::whereRaw('quantity <= minimum_stock')->count() }} bajo stock
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">Control de stock e inventario</p>
                    <a href="{{ route('inventory.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white font-bold rounded">
                        Ver Inventario
                    </a>
                </div>
            </div>

            <!-- Compras -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Compras</h3>
                        <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                            {{ \App\Models\Purchase::where('status', 'pending')->count() }} pendientes
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">Registro de compras y proveedores</p>
                    <a href="{{ route('purchases.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-purple-500 hover:bg-purple-700 text-white font-bold rounded">
                        Ver Compras
                    </a>
                </div>
            </div>

            <!-- Resumen -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Resumen del Día</h3>
                        <span class="px-3 py-1 text-sm rounded-full bg-indigo-100 text-indigo-800">
                            ${{ number_format(\App\Models\Order::whereDate('created_at', today())->sum('total'), 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-600">
                            Órdenes hoy: {{ \App\Models\Order::whereDate('created_at', today())->count() }}
                        </p>
                        <p class="text-gray-600">
                            Mesas ocupadas: {{ \App\Models\Table::where('status', 'occupied')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
