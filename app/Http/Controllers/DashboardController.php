<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Stock;
use App\Models\Sucursal;
use App\Models\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sucursalSeleccionada = $request->get('sucursal_id');

        $ventasQuery = Venta::query();
        $stockQuery = Stock::query()->with('producto');

        if ($sucursalSeleccionada) {
            $ventasQuery->where('sucursal_id', $sucursalSeleccionada);
            $stockQuery->where('sucursal_id', $sucursalSeleccionada);
        }

        $ventasDelMes = $ventasQuery->whereMonth('fecha', now()->month)->sum('total');
        $stockTotal = (clone $stockQuery)->sum('cantidad');
        $productosStockBajo = (clone $stockQuery)
            ->whereHas('producto', fn ($q) => $q->whereRaw('stock <= stock_minimo'))
            ->with('producto')
            ->get();

        $ultimasVentas = Venta::with(['sucursal', 'usuario'])
            ->when($sucursalSeleccionada, fn ($q) => $q->where('sucursal_id', $sucursalSeleccionada))
            ->orderByDesc('fecha')
            ->limit(8)
            ->get();

        $ventasPorDia = Venta::selectRaw('CAST(fecha AS DATE) as dia, SUM(total) as total')
            ->when($sucursalSeleccionada, fn ($q) => $q->where('sucursal_id', $sucursalSeleccionada))
            ->where('fecha', '>=', now()->subDays(7))
            ->groupByRaw('CAST(fecha AS DATE)')
            ->orderByRaw('CAST(fecha AS DATE)')
            ->get();

        $totalMovimientos = Movimiento::query()
            ->when($sucursalSeleccionada, fn ($q) => $q->where('sucursal_id', $sucursalSeleccionada))
            ->count();

        $entradasSucursal = Movimiento::query()
            ->where('tipo', 'entrada')
            ->when($sucursalSeleccionada, fn ($q) => $q->where('sucursal_id', $sucursalSeleccionada))
            ->sum('cantidad');

        $salidasSucursal = Movimiento::query()
            ->where('tipo', 'salida')
            ->when($sucursalSeleccionada, fn ($q) => $q->where('sucursal_id', $sucursalSeleccionada))
            ->sum('cantidad');

        $ventasPorSucursal = Venta::selectRaw('sucursal_id, SUM(total) as total')
            ->when($sucursalSeleccionada, fn ($q) => $q->where('sucursal_id', $sucursalSeleccionada))
            ->groupBy('sucursal_id')
            ->with('sucursal')
            ->get();

        $movimientosRecientes = Movimiento::with(['producto', 'sucursal'])
            ->when($sucursalSeleccionada, fn ($q) => $q->where('sucursal_id', $sucursalSeleccionada))
            ->orderByDesc('fecha')
            ->limit(6)
            ->get();

        return view('dashboard.index', [
            'ventasDelMes' => $ventasDelMes,
            'stockTotal' => $stockTotal,
            'productosStockBajo' => $productosStockBajo,
            'ultimasVentas' => $ultimasVentas,
            'ventasPorDia' => $ventasPorDia,
            'sucursales' => Sucursal::where('activo', true)->get(),
            'sucursalSeleccionada' => $sucursalSeleccionada,
            'totalMovimientos' => $totalMovimientos,
            'sucursalesActivas' => Sucursal::where('activo', true)->count(),
            'entradasSucursal' => $entradasSucursal,
            'salidasSucursal' => $salidasSucursal,
            'ventasPorSucursal' => $ventasPorSucursal,
            'movimientosRecientes' => $movimientosRecientes,
        ]);
    }
}