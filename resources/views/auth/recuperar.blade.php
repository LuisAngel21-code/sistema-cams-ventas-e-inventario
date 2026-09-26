@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 bg-[#f8fafc]">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#1e3a5f] text-white mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h1 class="text-xl font-bold text-slate-800">Recuperar contraseña</h1>
            </div>
            @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm mb-4">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('recuperar') }}" class="space-y-4">
                @csrf
                <input type="email" name="username" required placeholder="tu@correo.com"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/20 outline-none transition-all">
                <button class="w-full py-3 rounded-lg bg-[#1e3a5f] text-white font-medium hover:bg-[#16304f] active:scale-[0.99] transition-all">
                    Enviar enlace de recuperacion
                </button>
                <a href="{{ route('login') }}" class="block text-center text-sm text-[#1e3a5f] hover:underline">Volver al login</a>
            </form>
        </div>
    </div>
</div>
@endsection