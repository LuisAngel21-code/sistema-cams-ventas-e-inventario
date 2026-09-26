<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->startOfMonth()->toDateString());
        $fechaFin = $request->get('fecha_fin', now()->toDateString());

        $ventasTotales = Venta::filtradasPorRango($fechaInicio, $fechaFin)->sum('total');
        $cantidadVentas = Venta::filtradasPorRango($fechaInicio, $fechaFin)->count();

        $ventasPorSucursal = Venta::filtradasPorRango($fechaInicio, $fechaFin)
            ->selectRaw('sucursal_id, SUM(total) as total')
            ->groupBy('sucursal_id')
            ->with('sucursal')
            ->get();

        $productosStockBajo = Producto::whereRaw('stock <= stock_minimo')->get();
        $movimientosRecientes = Movimiento::with('producto')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->orderByDesc('fecha')
            ->limit(50)
            ->get();

        return view('reportes.index', [
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'ventasTotales' => $ventasTotales,
            'cantidadVentas' => $cantidadVentas,
            'ventasPorSucursal' => $ventasPorSucursal,
            'productosStockBajo' => $productosStockBajo,
            'movimientosRecientes' => $movimientosRecientes,
        ]);
    }
}