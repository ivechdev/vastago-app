<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Datos para los gráficos
        $usedTables = Table::where('status', 'occupied')->count();
        $totalOrders = Order::count();
        $totalIncome = Order::sum('total');

        // Mesas usadas hoy
        $tablesUsedToday = Table::whereHas('orders', function($query) use ($today) {
            $query->whereDate('created_at', $today);
        })->count();

        // Ingresos del día
        $dailyIncome = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total') ?? 0;

        // Órdenes generadas hoy
        $dailyOrders = Order::whereDate('created_at', $today)->count();

        return view('dashboard.index', compact(
            'usedTables',
            'totalOrders',
            'totalIncome',
            'tablesUsedToday',
            'dailyIncome',
            'dailyOrders'
        ));
    }
}
