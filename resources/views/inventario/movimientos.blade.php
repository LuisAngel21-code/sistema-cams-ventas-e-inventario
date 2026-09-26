@extends('layouts.app')

@section('titulo', 'Movimientos')
@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Movimientos de inventario</h1>
            <p class="text-slate-500 text-sm mt-1">Ingresos y salidas de productos</p>
        </div>
        <a href="{{ route('inventario.ingreso') }}" class="px-4 py-2.5 rounded-lg bg-[#1e3a5f] text-white text-sm font-medium hover:bg-[#16304f] transition-colors">+ Registrar ingreso</a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500 border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4">Fecha</th>
                    <th class="py-3 px-4">Producto</th>
                    <th class="py-3 px-4">Tipo</th>
                    <th class="py-3 px-4 text-right">Cantidad</th>
                    <th class="py-3 px-4">Sucursal</th>
                    <th class="py-3 px-4">Motivo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movimientos as $movimiento)
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="py-3 px-4 text-slate-600">{{ $movimiento->fecha->format('d/m/Y H:i') }}</td>
                    <td class="py-3 px-4 font-medium text-slate-700">{{ $movimiento->producto->nombre }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $movimiento->tipo === 'entrada' ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-amber-50 border border-amber-200 text-amber-700' }}">
                            {{ $movimiento->tipo }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right font-medium text-slate-800">{{ $movimiento->cantidad }}</td>
                    <td class="py-3 px-4 text-slate-600">{{ $movimiento->sucursal->nombre }}</td>
                    <td class="py-3 px-4 text-slate-500">{{ $movimiento->motivo }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-slate-500">Sin movimientos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $movimientos->links() }}</div>
</div>
@endsection