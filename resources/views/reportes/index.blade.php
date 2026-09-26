@extends('layouts.app')

@section('titulo', 'Reportes')
@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Reportes</h1>
            <p class="text-slate-500 text-sm mt-1">Ventas e inventario para toma de decisiones</p>
        </div>
    </div>

    <form class="flex gap-2 mb-6 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:border-[#1e3a5f] outline-none">
        <input type="date" name="fecha_fin" value="{{ $fechaFin }}" class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:border-[#1e3a5f] outline-none">
        <button class="px-4 py-2 rounded-lg bg-[#1e3a5f] text-white text-sm hover:bg-[#16304f]">Generar</button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Ventas totales (periodo)</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">S/ {{ number_format($ventasTotales, 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Cantidad de ventas</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $cantidadVentas }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ventas por sucursal -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <h2 class="font-semibold text-slate-700 mb-4">Ventas por sucursal</h2>
            <div class="space-y-3">
                @forelse ($ventasPorSucursal as $venta)
                <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                    <span class="text-sm text-slate-700">{{ $venta->sucursal->nombre }}</span>
                    <span class="text-sm font-medium text-slate-800">S/ {{ number_format($venta->total, 2) }}</span>
                </div>
                @empty
                <p class="text-sm text-slate-500">Sin ventas en el periodo.</p>
                @endforelse
            </div>
        </div>

        <!-- Stock bajo -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <h2 class="font-semibold text-slate-700 mb-4">Inventario - stock bajo</h2>
            <div class="space-y-3">
                @forelse ($productosStockBajo as $producto)
                <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                    <div>
                        <p class="text-sm font-medium text-slate-700">{{ $producto->nombre }}</p>
                        <p class="text-xs text-slate-500">{{ $producto->categoria }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-xs font-medium">{{ $producto->stock }} unid.</span>
                </div>
                @empty
                <p class="text-sm text-slate-500">Sin alertas de stock bajo.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection