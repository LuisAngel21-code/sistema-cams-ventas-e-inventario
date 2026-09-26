@extends('layouts.app')

@section('titulo', 'Registrar ingreso')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h1 class="text-xl font-bold text-slate-800 mb-6">Registrar ingreso de mercaderia</h1>
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
            <ul class="list-disc pl-4">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif
        <form method="POST" action="{{ route('inventario.ingreso') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Producto recibido</label>
                <select name="producto_id" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-600 bg-white focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/10 outline-none transition-all">
                    @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->codigo }} - {{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Sucursal</label>
                <select name="sucursal_id" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-600 bg-white focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/10 outline-none transition-all">
                    @foreach (\App\Models\Sucursal::where('activo', true)->get() as $sucursal)
                    <option value="{{ $sucursal->id }}" @selected($sucursal->id === auth()->user()->sucursal_id)>{{ $sucursal->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Cantidad ingresada</label>
                <input name="cantidad" type="number" min="1" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/10 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Motivo (opcional)</label>
                <input name="motivo" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/10 outline-none transition-all" placeholder="Ej: reposicion de almacen">
            </div>
            <button class="w-full inline-flex items-center justify-center gap-2 py-3 rounded-xl bg-[#1e3a5f] text-white font-medium hover:bg-[#16304f] hover:shadow-md transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 3h5v5"/><path d="M21 3l-7 7"/><path d="M3 12v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-3"/></svg>
                Registrar ingreso
            </button>
        </form>
    </div>
</div>
@endsection