@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6">Reporte general Total</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Mesas Usadas</h3>
                <canvas id="usedTablesChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Total de Órdenes</h3>
                <canvas id="totalOrdersChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Ingresos Totales</h3>
                <canvas id="totalIncomeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const usedTablesCtx = document.getElementById('usedTablesChart').getContext('2d');
    const totalOrdersCtx = document.getElementById('totalOrdersChart').getContext('2d');
    const totalIncomeCtx = document.getElementById('totalIncomeChart').getContext('2d');

    const usedTablesChart = new Chart(usedTablesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Mesas Usadas', 'Mesas Libres'],
            datasets: [{
                data: [{{ $usedTables }}, {{ $tablesUsedToday - $usedTables }}],
                backgroundColor: ['#FF6384', '#36A2EB'],
            }]
        }
    });

    const totalOrdersChart = new Chart(totalOrdersCtx, {
        type: 'bar',
        data: {
            labels: ['Total de Órdenes'],
            datasets: [{
                label: 'Órdenes',
                data: [{{ $totalOrders }}],
                backgroundColor: '#FFCE56',
            }]
        }
    });

    const totalIncomeChart = new Chart(totalIncomeCtx, {
        type: 'line',
        data: {
            labels: ['Ingresos Totales'],
            datasets: [{
                label: 'Ingresos',
                data: [{{ $totalIncome }}],
                borderColor: '#4BC0C0',
                fill: false,
            }]
        }
    });
</script>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold">Estadisticas generales</h2>
            <img src="{{ asset('images/vastago_black.png') }}" alt="Restaurante Vastago" class="h-16">
        </div>

        <!-- Resumen del Día -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Mesas Usadas -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Mesas Usadas</h3>
                <div class="flex items-center">
                    <span class="text-3xl font-bold">{{ $tablesUsedToday }}</span>
                    <span class="ml-2 text-sm text-gray-600">hoy</span>
                </div>
            </div>

            <!-- Ingresos -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Ingresos</h3>
                <div class="flex items-center">
                    <span class="text-3xl font-bold">${{ number_format($dailyIncome, 0, ',', '.') }}</span>
                    <span class="ml-2 text-sm text-gray-600">hoy</span>
                </div>
            </div>

            <!-- Órdenes -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Órdenes</h3>
                <div class="flex items-center">
                    <span class="text-3xl font-bold">{{ $dailyOrders }}</span>
                    <span class="ml-2 text-sm text-gray-600">generadas hoy</span>
                </div>
            </div>
        </div>

        <!-- Productos Más Vendidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Menú Más Pedido -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold">Menú Más Pedido</h3>
                </div>
                <div class="card-body">
                    @if($topMenu)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xl font-bold">{{ $topMenu->name }}</p>
                                <p class="text-sm text-gray-600">{{ $topMenu->total_quantity }} unidades</p>
                            </div>
                            <span class="badge badge-success">Top</span>
                        </div>
                    @else
                        <p class="text-gray-600">Sin datos para hoy</p>
                    @endif
                </div>
            </div>

            <!-- Bebestible Más Pedido -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold">Bebestible Más Pedido</h3>
                </div>
                <div class="card-body">
                    @if($topDrink)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xl font-bold">{{ $topDrink->name }}</p>
                                <p class="text-sm text-gray-600">{{ $topDrink->total_quantity }} unidades</p>
                            </div>
                            <span class="badge badge-success">Top</span>
                        </div>
                    @else
                        <p class="text-gray-600">Sin datos para hoy</p>
                    @endif
                </div>
            </div>

            <!-- Insumos Más Usados -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold">Insumos Más Usados</h3>
                </div>
                <div class="card-body">
                    @if($topIngredients->isNotEmpty())
                        <ul class="space-y-2">
                            @foreach($topIngredients as $ingredient)
                                <li class="flex justify-between items-center">
                                    <span>{{ $ingredient->name }}</span>
                                    <span class="text-sm text-gray-600">{{ $ingredient->total_used }} unidades</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">Sin datos para hoy</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Resto de las cards del dashboard... -->
    </div>
</div>
@endsection