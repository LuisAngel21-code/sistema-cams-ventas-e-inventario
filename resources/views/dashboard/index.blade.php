@extends('layouts.app')

@section('titulo', 'Dashboard')
@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-[#1e293b]">Dashboard</h1>
            <p class="text-slate-500 text-sm mt-1">Estado del negocio y operaciones</p>
        </div>
        <form method="GET" action="{{ route('dashboard') }}">
            <select name="sucursal_id" onchange="this.form.submit()" class="px-4 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-600 bg-white shadow-sm focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/10 outline-none transition-all">
                <option value="">Todas las sucursales</option>
                @foreach ($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}" @selected($sucursalSeleccionada == $sucursal->id)>{{ $sucursal->nombre }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Zona 1: KPI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-11 h-11 rounded-xl bg-[#1e3a5f]/10 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-[#1e3a5f]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <p class="text-sm text-slate-500">Ventas del mes</p>
            <p class="text-2xl font-bold text-[#1e293b] mt-1">S/ {{ number_format($ventasDelMes, 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-11 h-11 rounded-xl bg-[#334155]/10 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-[#334155]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <p class="text-sm text-slate-500">Stock total</p>
            <p class="text-2xl font-bold text-[#1e293b] mt-1">{{ number_format($stockTotal) }} unidades</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-11 h-11 rounded-xl bg-[#3f6b4f]/10 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-[#3f6b4f]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-9-9"/><path d="M21 3v6h-6"/></svg>
            </div>
            <p class="text-sm text-slate-500">Movimientos</p>
            <p class="text-2xl font-bold text-[#1e293b] mt-1">{{ $totalMovimientos }}</p>
            <p class="text-xs text-slate-400 mt-1">Entradas {{ number_format($entradasSucursal) }} · Salidas {{ number_format($salidasSucursal) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-11 h-11 rounded-xl bg-[#64748b]/10 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-[#64748b]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/></svg>
            </div>
            <p class="text-sm text-slate-500">Sucursales activas</p>
            <p class="text-2xl font-bold text-[#1e293b] mt-1">{{ $sucursalesActivas }}</p>
        </div>
    </div>

    <!-- Zona 2: Graficas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-semibold text-[#1e293b]">Ventas últimos 7 días</h2>
                <span class="text-xs text-slate-400">Total: S/ {{ number_format($ventasPorDia->sum('total'), 0) }}</span>
            </div>
            <div class="h-56">
                <canvas id="chart-ventas"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-semibold text-[#1e293b]">Ventas por sucursal</h2>
            </div>
            <div class="h-56 flex items-center justify-center">
                <canvas id="chart-sucursales"></canvas>
            </div>
        </div>
    </div>

    <!-- Zona 3: Alertas + Movimientos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-semibold text-[#1e293b]">Productos con stock bajo</h2>
                <span class="text-xs text-slate-400">{{ $productosStockBajo->count() }} alertas</span>
            </div>
            <div class="space-y-3">
                @forelse ($productosStockBajo as $stock)
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-700 text-sm">{{ $stock->producto->nombre }}</p>
                            <p class="text-xs text-slate-500">{{ $stock->producto->categoria }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-xs font-medium">
                        {{ $stock->cantidad }} unid.
                    </span>
                </div>
                @empty
                <p class="text-sm text-slate-500 py-8 text-center">Sin alertas de stock bajo.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-semibold text-[#1e293b]">Movimientos recientes</h2>
                <a href="{{ route('inventario.movimientos') }}" class="text-xs text-[#1e3a5f] hover:underline">Ver todos</a>
            </div>
            <div class="space-y-3">
                @forelse ($movimientosRecientes as $movimiento)
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg {{ $movimiento->tipo === 'entrada' ? 'bg-emerald-100' : 'bg-orange-100' }} flex items-center justify-center">
                            @if ($movimiento->tipo === 'entrada')
                            <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg>
                            @else
                            <svg class="w-4 h-4 text-orange-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 5v14"/><path d="M19 12l-7 7-7-7"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-slate-700 text-sm">{{ $movimiento->producto->nombre }}</p>
                            <p class="text-xs text-slate-500">{{ $movimiento->fecha->format('d/m/Y H:i') }} · {{ $movimiento->sucursal->nombre }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $movimiento->tipo === 'entrada' ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-orange-50 border border-orange-200 text-orange-700' }}">
                        {{ $movimiento->tipo }} · {{ $movimiento->cantidad }}
                    </span>
                </div>
                @empty
                <p class="text-sm text-slate-500 py-8 text-center">Sin movimientos registrados.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Zona 4: Ultimas ventas -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-semibold text-[#1e293b]">Últimas ventas</h2>
            <a href="{{ route('ventas.historial') }}" class="text-xs text-[#1e3a5f] hover:underline">Ver historial</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-400 text-xs uppercase tracking-wide border-b border-slate-100">
                        <th class="py-2.5 pr-4">Fecha</th>
                        <th class="py-2.5 pr-4">Sucursal</th>
                        <th class="py-2.5 pr-4">Cliente</th>
                        <th class="py-2.5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ultimasVentas as $venta)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 pr-4 text-slate-600">{{ $venta->fecha->format('d/m/Y H:i') }}</td>
                        <td class="py-3 pr-4 text-slate-600">{{ $venta->sucursal->nombre }}</td>
                        <td class="py-3 pr-4 text-slate-600">{{ $venta->cliente_nombre ?? '—' }}</td>
                        <td class="py-3 text-right font-medium text-[#1e293b]">S/ {{ number_format($venta->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-8 text-center text-slate-500">Sin ventas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#64748b';

    var ventasDias = @json($ventasPorDia->map(fn ($v) => ['dia' => \Carbon\Carbon::parse($v->dia)->format('d/m'), 'total' => (float) $v->total]));
    var ventasSucu = @json($ventasPorSucursal->map(fn ($v) => ['nombre' => $v->sucursal->nombre, 'total' => (float) $v->total]));

    new Chart(document.getElementById('chart-ventas'), {
        type: 'bar',
        data: {
            labels: ventasDias.map(function (v) { return v.dia; }),
            datasets: [{
                label: 'Ventas (S/)',
                data: ventasDias.map(function (v) { return v.total; }),
                backgroundColor: '#1e3a5f',
                hoverBackgroundColor: '#2a4a75',
                borderRadius: 6,
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { callback: function (v) { return 'S/' + v; } } },
            },
        },
    });

    new Chart(document.getElementById('chart-sucursales'), {
        type: 'doughnut',
        data: {
            labels: ventasSucu.map(function (v) { return v.nombre; }),
            datasets: [{
                data: ventasSucu.map(function (v) { return v.total; }),
                backgroundColor: ['#1e3a5f', '#334155', '#64748b'],
                borderWidth: 0,
            }],
        },
        options: {
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { callbacks: { label: function (c) { return ' ' + c.label + ': S/' + c.parsed; } } },
            },
        },
    });
})();
</script>
@endsection