@extends('layouts.app')

@section('titulo', 'Sucursales')
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-[#1e293b]">Sucursales</h1>
            <p class="text-slate-500 text-sm mt-1">Gestion de sucursales</p>
        </div>
        <a href="{{ route('sucursales.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#1e3a5f] text-white text-sm font-medium hover:bg-[#16304f] transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Nueva sucursal
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($sucursales as $sucursal)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-xl bg-[#1e3a5f]/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#1e3a5f]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 9h1"/><path d="M9 13h1"/><path d="M9 17h1"/></svg>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $sucursal->activo ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-slate-100 border border-slate-200 text-slate-500' }}">
                    {{ $sucursal->activo ? 'Activa' : 'Inactiva' }}
                </span>
            </div>
            <h2 class="font-semibold text-[#1e293b] mt-4">{{ $sucursal->nombre }}</h2>
            <p class="text-sm text-slate-500 mt-1 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ $sucursal->direccion }}
            </p>
            <div class="flex items-center gap-4 mt-3 text-xs text-slate-400">
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    {{ $sucursal->telefono }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    {{ $sucursal->usuarios_count }} usuarios
                </span>
            </div>
            <form method="POST" action="{{ route('sucursales.estado', $sucursal) }}" class="mt-5 pt-4 border-t border-slate-100">
                @csrf @method('PUT')
                <button class="inline-flex items-center gap-1.5 text-xs font-medium {{ $sucursal->activo ? 'text-slate-500 hover:text-red-600' : 'text-emerald-600 hover:text-emerald-700' }} transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><path d="M12 2v10"/></svg>
                    {{ $sucursal->activo ? 'Desactivar' : 'Activar' }} sucursal
                </button>
            </form>
        </div>
        @empty
        <p class="text-sm text-slate-500 col-span-3 text-center py-12">No hay sucursales registradas.</p>
        @endforelse
    </div>
</div>
@endsection