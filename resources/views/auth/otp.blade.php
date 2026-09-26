@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 bg-[#f8fafc]">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#1e3a5f] text-white mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h1 class="text-xl font-bold text-slate-800">Verificacion</h1>
                <p class="text-sm text-slate-500 mt-1">Ingresa el codigo de 6 digitos enviado</p>
            </div>
            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">{{ $errors->first() }}</div>
            @endif
            @if ($otpDebug)
            <div class="bg-slate-100 border border-slate-200 text-slate-600 px-4 py-3 rounded-lg text-sm mb-4 text-center">
                Codigo de prueba (dev): <strong class="text-[#1e3a5f] tracking-widest">{{ $otpDebug }}</strong>
            </div>
            @endif
            <form method="POST" action="{{ route('login.otp') }}" class="space-y-4">
                @csrf
                <input type="text" name="codigo" maxlength="6" required autofocus
                    class="w-full text-center text-2xl tracking-widest px-4 py-3 rounded-lg border border-slate-300 focus:border-[#1e3a5f] focus:ring-2 focus:ring-[#1e3a5f]/20 outline-none transition-all" placeholder="••••••">
                <button type="submit" class="w-full py-3 rounded-lg bg-[#1e3a5f] text-white font-medium hover:bg-[#16304f] active:scale-[0.99] transition-all">
                    Verificar acceso
                </button>
            </form>
        </div>
    </div>
</div>
@endsection