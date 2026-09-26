@extends('layouts.app')

@section('titulo', 'Detalle de venta')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Venta #{{ $venta->id }}</h1>
                <p class="text-sm text-slate-500 mt-1">{{ $venta->fecha->format('d/m/Y H:i') }} - {{ $venta->sucursal->nombre }}</p>
                <p class="text-sm text-slate-500">Registrada por: {{ $venta->usuario->username }}</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">{{ $venta->estado }}</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6 text-sm">
            <div class="p-3 rounded-lg bg-slate-50">
                <p class="text-xs text-slate-500">Cliente</p>
                <p class="font-medium text-slate-700">{{ $venta->cliente_nombre ?? '—' }}</p>
            </div>
            <div class="p-3 rounded-lg bg-slate-50">
                <p class="text-xs text-slate-500">Vendedor</p>
                <p class="font-medium text-slate-700">{{ $venta->vendedor_nombre ?? '—' }}</p>
            </div>
            <div class="p-3 rounded-lg bg-slate-50">
                <p class="text-xs text-slate-500">Tipo de pago</p>
                <p class="font-medium text-slate-700">{{ $venta->tipo_pago ?? '—' }}</p>
            </div>
            <div class="p-3 rounded-lg bg-slate-50">
                <p class="text-xs text-slate-500">Comprobante</p>
                <p class="font-medium text-slate-700">{{ $venta->comprobante_tipo ?? '—' }}</p>
            </div>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500 border-b border-slate-200">
                    <th class="py-2 pr-4">Producto</th>
                    <th class="py-2 pr-4 text-right">Cantidad</th>
                    <th class="py-2 pr-4 text-right">Precio</th>
                    <th class="py-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalleVentas as $detalle)
                <tr class="border-b border-slate-100">
                    <td class="py-3 pr-4 text-slate-700">{{ $detalle->producto->nombre }}</td>
                    <td class="py-3 pr-4 text-right text-slate-600">{{ $detalle->cantidad }}</td>
                    <td class="py-3 pr-4 text-right text-slate-600">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td class="py-3 text-right font-medium text-slate-800">S/ {{ number_format($detalle->calcularSubtotal(), 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="py-3 pr-4 text-right font-semibold text-slate-700">Total</td>
                    <td class="py-3 text-right font-bold text-slate-800">S/ {{ number_format($venta->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection