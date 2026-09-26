@extends('layouts.app')

@section('titulo', 'Nueva sucursal')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h1 class="text-xl font-bold text-slate-800 mb-6">Registrar sucursal</h1>
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
            <ul class="list-disc pl-4">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif
        <form method="POST" action="{{ route('sucursales.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Nombre</label>
                <input name="nombre" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/10 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Direccion</label>
                <input name="direccion" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/10 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Telefono</label>
                <input name="telefono" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/10 outline-none transition-all">
            </div>
            <button class="w-full inline-flex items-center justify-center gap-2 py-3 rounded-xl bg-[#1e3a5f] text-white font-medium hover:bg-[#16304f] hover:shadow-md transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/></svg>
                Registrar sucursal
            </button>
        </form>
    </div>
</div>
@endsection