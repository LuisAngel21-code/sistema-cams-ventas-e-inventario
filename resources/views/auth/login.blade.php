@extends('layouts.guest')

@section('content')
<main class="auth-wrap">
    <!-- Panel izquierdo: marca -->
    <section class="brand-panel">
        <video class="brand-video" autoplay muted loop playsinline aria-hidden="true">
            <source src="{{ asset('videos/video_cams2026.mp4') }}" type="video/mp4">
        </video>
        <div class="brand-overlay"></div>
        <div class="brand-inner">
            <div class="brand-lockup">
                <img src="{{ asset('logo.png') }}" alt="Logo CAMS" class="brand-logo">
            </div>
            <p class="brand-line">Mueblería y control de inventario</p>
            <div class="brand-quote">
                <p class="quote-big">Inventario y ventas</p>
                <p class="quote-big accent">en equilibrio</p>
            </div>
            <p class="brand-sub">Stock por sucursal, movimientos trazados y decisiones con datos</p>
            <div class="benefits">
                <div class="benefit">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="M3.27 6.96L12 12.01l8.73-5.05"/><path d="M12 22.08V12"/></svg>
                    <span>Stock siempre<br>actualizado</span>
                </div>
                <div class="benefit">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M8 17V9"/><path d="M13 17V5"/><path d="M18 17v-3"/></svg>
                    <span>Ventas<br>organizadas</span>
                </div>
                <div class="benefit">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path d="M21.2 15.9A10 10 0 1 1 8 2.8"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
                    <span>Mejores<br>decisiones</span>
                </div>
            </div>
        </div>
        <p class="brand-foot">Panel interno · Uso exclusivo del equipo CAMS</p>
    </section>

    <!-- Panel derecho: acceso -->
    <section class="form-panel" id="access-panel">
        <div class="form-inner">
            <div class="login-card">

            @if ($errors->any())
            <div class="message error is-visible" data-role="global">{{ $errors->first() }}</div>
            @endif
            @if (session('status'))
            <div class="message success is-visible" data-role="global">{{ session('status') }}</div>
            @endif

            <!-- PASO 1: LOGIN (HU-01) -->
            <form class="step {{ $verificar ? '' : 'is-active' }}" data-step="login" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="step-head">
                    <span class="step-tag">Acceso</span>
                    <h1>Inicia sesión</h1>
                    <p>Ingresa tus credenciales para entrar al panel.</p>
                </div>

                <div class="field">
                    <label>Correo electrónico</label>
                    <div class="field-input">
                        <svg class="field-icon" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 6L2 7"/></svg>
                        <input type="email" name="username" value="{{ old('username') }}" autocomplete="username" required placeholder="usuario@cams.com">
                        <span class="underline"></span>
                    </div>
                </div>
                <div class="field">
                    <label>Contraseña</label>
                    <div class="field-input password-input">
                        <svg class="field-icon" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" name="password" id="login-password" autocomplete="current-password" required placeholder="Ingresa tu contraseña">
                        <span class="underline"></span>
                        <button type="button" class="toggle-password" data-toggle-password="login-password" aria-label="Mostrar contraseña" title="Mostrar contraseña">
                            <svg class="eye-open" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-closed" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/><path d="M2 2l20 20"/></svg>
                        </button>
                    </div>
                </div>

                <div class="row-between">
                    <label class="remember"><input type="checkbox" name="remember" value="1"> Recordarme</label>
                    <button type="button" class="link" data-goto="forgot">¿Olvidaste tu contraseña?</button>
                </div>

                <button type="submit" class="btn-primary" data-role="login-btn">
                    <span>Acceder</span>
                    <span class="spinner" aria-hidden="true"></span>
                    <span class="arrow">→</span>
                </button>
            </form>

            <!-- PASO 2: RECUPERAR (HU-02) -->
            <form class="step" data-step="forgot" method="POST" action="{{ route('recuperar') }}">
                @csrf
                <div class="step-head">
                    <span class="step-tag">Recuperar acceso</span>
                    <h1>Recupera tu contraseña</h1>
                    <p>Escribe tu correo y te enviaremos instrucciones.</p>
                </div>

                <div class="field">
                    <label>Correo electrónico</label>
                    <div class="field-input">
                        <input type="email" name="username" autocomplete="email" required placeholder="usuario@cams.com">
                        <span class="underline"></span>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Enviar instrucciones</button>
                <div class="row-between" style="margin-top:18px;">
                    <button type="button" class="link" data-goto="login">← Volver</button>
                    <span></span>
                </div>
            </form>

            <!-- PASO 3: VERIFICACIÓN (HU-03) - pantalla separada animada -->
            <div class="step {{ $verificar ? 'is-active' : '' }}" data-step="verify">
                <a href="{{ route('login.cancelar') }}" class="back-link" title="Volver a iniciar sesión">
                    <span class="back-arrow">←</span> Volver
                </a>
                <div class="step-head">
                    <span class="step-tag">Verificación</span>
                    <h1>Confirma que eres tú</h1>
                    <p>{{ $verificar && !$qrDataUri ? 'Ingresa el código de 6 dígitos de tu aplicación autenticadora.' : 'Escanea el código y escribe el de 6 dígitos para continuar.' }}</p>
                </div>

                @if ($qrDataUri)
                <div class="qr-wrap">
                    <div class="qr-box"><img src="{{ $qrDataUri }}" alt="Código QR de autenticación" width="160" height="160"></div>
                    <div class="qr-note">
                        <strong>Primera vez</strong>
                        <span>Escanea con Google Authenticator o Authy. Si no puedes escanear, escribe esta clave manualmente:</span>
                        <code class="qr-key">{{ $qrSecret }}</code>
                    </div>
                </div>
                @endif

                <p class="verify-hint">Si ya escaneaste el código, solo digita tu clave.</p>

                <form method="POST" action="{{ route('login.verificar') }}" class="otp-form">
                    @csrf
                    <div class="code-row" role="group" aria-label="Código de verificación">
                        <input type="text" inputmode="numeric" maxlength="1" aria-label="Dígito 1" class="otp-digit" autofocus>
                        <input type="text" inputmode="numeric" maxlength="1" aria-label="Dígito 2" class="otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" aria-label="Dígito 3" class="otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" aria-label="Dígito 4" class="otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" aria-label="Dígito 5" class="otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" aria-label="Dígito 6" class="otp-digit">
                    </div>
                    <input type="hidden" name="codigo" id="otp-hidden">

                    <div class="timer-row">
                        <span>El código expira en <strong data-role="timer">0:30</strong></span>
                    </div>

                    <button type="submit" class="btn-primary" data-role="verify-btn">
                        <span>Verificar acceso</span>
                        <span class="arrow">→</span>
                    </button>
                </form>

                <div class="loader" data-role="loader" aria-hidden="true">
                    <span class="loader-ring"></span>
                </div>
            </div>

            </div>

        </div>
    </section>
</main>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root{
    --navy:#1e3a5f; --navy-deep:#16304f; --navy-soft:#244066;
    --slate-900:#1e293b; --slate-700:#334155; --slate-500:#64748b; --slate-400:#94a3b8;
    --surface:#ffffff; --bg:#f8fafc; --line:#e2e8f0;
    --error:#b3423a; --error-bg:#fbeae9; --ok:#3f6b4f; --ok-bg:#eaf2ec;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--slate-900);-webkit-font-smoothing:antialiased}
.auth-wrap{min-height:100vh;display:grid;grid-template-columns:50% 50%}

/* Panel izquierdo - marca */
.brand-panel{
    position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:space-between;
    background:var(--navy-deep);
    color:#fff;padding:48px 46px;
}
.brand-video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0}
.brand-overlay{position:absolute;inset:0;z-index:1;
    background:linear-gradient(150deg,rgba(22,48,79,.55) 0%,rgba(30,58,95,.4) 45%,rgba(36,64,102,.5) 100%);
}
.brand-panel::before{
    content:"";position:absolute;inset:0;z-index:1;opacity:.07;pointer-events:none;
    background-image:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="120" height="120"><filter id="n"><feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="2"/></filter><rect width="100%25" height="100%25" filter="url(%23n)" opacity="0.7"/></svg>');
}
.brand-panel::after{
    content:"";position:absolute;right:-120px;bottom:-120px;width:340px;height:340px;border-radius:50%;
    background:radial-gradient(circle,rgba(255,255,255,.12) 0%,transparent 70%);
}
.brand-inner{position:relative;z-index:2;text-align:center}
.brand-lockup{display:flex;align-items:center;justify-content:center}
.brand-logo{height:96px;width:auto;object-fit:contain;background:#fff;border-radius:14px;padding:10px;box-shadow:0 10px 30px rgba(0,0,0,.25);margin:0 auto;display:block}
.brand-line{text-align:center;margin-top:18px}
.brand-cube{width:26px;height:26px;background:#fff;transform:rotate(45deg);border-radius:3px}
.brand-name{font-family:'Inter',sans-serif;font-size:2rem;font-weight:700;letter-spacing:.02em}
.brand-line{margin-top:10px;font-size:.95rem;color:rgba(255,255,255,.94);letter-spacing:.02em}
.brand-quote{margin-top:64px}
.quote-big{font-family:'Inter',sans-serif;font-size:clamp(2.2rem,4vw,3.2rem);font-weight:700;line-height:1.05;letter-spacing:-.02em}
.quote-big.accent{color:#c4d9f2}
.brand-sub{margin:24px auto 0;color:rgba(255,255,255,.94);font-size:.95rem;line-height:1.6;max-width:36ch;border:none;padding-left:0}
.brand-foot{position:relative;z-index:2;font-size:.75rem;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.84);text-align:center}

/* Panel derecho - acceso */
.form-panel{position:relative;display:flex;align-items:center;justify-content:center;background:#f4f7fb;padding:48px;overflow:hidden}
.form-panel::before{content:"";position:absolute;top:-140px;right:-140px;width:340px;height:340px;border-radius:50%;background:radial-gradient(circle,rgba(30,58,95,.06) 0%,transparent 70%)}
.form-panel::after{content:"";position:absolute;bottom:-120px;left:-80px;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(30,58,95,.05) 0%,transparent 70%)}
.form-inner{position:relative;z-index:1;width:min(560px,100%)}
.login-card{background:var(--surface);border:1px solid #e6ebf2;border-radius:16px;box-shadow:0 24px 55px -24px rgba(30,58,95,.22);padding:44px 44px}
.step{display:none}
.step.is-active{display:block;animation:step-in .5s ease}
@keyframes step-in{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
.step-head{margin-bottom:30px}
.back-link{display:inline-flex;align-items:center;gap:6px;margin-bottom:18px;color:var(--slate-500);font-size:.85rem;text-decoration:none;transition:color .2s,transform .2s}
.back-link:hover{color:var(--navy)}
.back-arrow{display:inline-block;transition:transform .2s}
.back-link:hover .back-arrow{transform:translateX(-4px)}
.step-tag{font-size:.82rem;letter-spacing:.16em;text-transform:uppercase;color:var(--navy);font-weight:600}
.step-tag::after{content:"";display:block;width:34px;height:2px;background:var(--navy);border-radius:2px;margin-top:8px}
.step-head h1{font-family:'Inter',sans-serif;font-weight:700;font-size:2.2rem;margin:14px 0 6px;color:var(--navy)}
.step-head p{color:var(--slate-500);font-size:1rem;line-height:1.5}

.field{margin-bottom:22px}
.field label{display:block;font-size:.88rem;font-weight:500;color:var(--slate-500);margin-bottom:9px}
.field-input{position:relative}
.field-input .field-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--slate-400);display:flex;pointer-events:none}
.field-input input{width:100%;height:52px;border:1px solid #d7dee8;border-radius:10px;background:var(--surface);padding:0 14px 0 44px;font-family:'Inter',sans-serif;font-size:15px;color:var(--slate-900);outline:none;transition:border-color .2s,box-shadow .2s}
.field-input input:focus{border-color:var(--navy);box-shadow:0 0 0 4px rgba(30,58,95,.09)}
.field-input input::placeholder{color:var(--slate-400);font-size:.9rem;opacity:1}
.underline{display:none}
.password-input{position:relative}
.password-input input{padding-right:44px}
.toggle-password{position:absolute;right:6px;top:50%;transform:translateY(-50%);border:0;background:none;padding:7px;cursor:pointer;color:var(--slate-400);border-radius:8px;display:flex;align-items:center;justify-content:center;transition:color .2s,background .2s}
.toggle-password:hover{color:var(--navy);background:rgba(30,58,95,.06)}
.row-between{display:flex;align-items:center;justify-content:space-between;margin:2px 0 24px}
.remember{display:flex;align-items:center;gap:8px;font-size:.85rem;color:var(--slate-500);cursor:pointer;user-select:none}
.remember input{accent-color:var(--navy);width:15px;height:15px;cursor:pointer}
.link{background:none;border:0;padding:0;color:var(--navy);font-size:.85rem;cursor:pointer;text-decoration:underline;text-underline-offset:3px}
.link:hover{color:var(--navy-deep)}

.btn-primary{
    width:100%;display:flex;align-items:center;justify-content:space-between;padding:15px 20px;border:0;border-radius:10px;
    background:var(--navy);color:#fff;font-size:.95rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;
    transition:background .25s,transform .15s,box-shadow .25s;
}
.btn-primary:hover{background:var(--navy-deep);box-shadow:0 14px 28px rgba(30,58,95,.22)}
.btn-primary:active{transform:scale(.98)}
.btn-primary .arrow{transition:transform .25s;font-size:1.1rem}
.btn-primary:hover .arrow{transform:translateX(5px)}
.btn-primary.is-loading{pointer-events:none;opacity:.85}
.btn-primary .spinner{display:none;width:16px;height:16px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}
.btn-primary.is-loading .spinner{display:inline-block}
.btn-primary.is-loading .arrow{display:none}
.benefits{display:flex;align-items:stretch;gap:0;margin-top:56px;position:relative;z-index:2}
.benefit{flex:1;display:flex;flex-direction:column;align-items:center;gap:8px;text-align:center;padding:0 14px}
.benefit + .benefit{border-left:1px solid rgba(255,255,255,.18)}
.benefit svg{color:#a0c2e4}
.benefit span{font-size:.74rem;line-height:1.45;color:rgba(255,255,255,.82)}

.message{display:none;font-size:.85rem;line-height:1.5;padding:11px 14px;border-radius:8px;margin-bottom:20px}
.message.is-visible{display:block}
.message.error{background:var(--error-bg);color:var(--error);border:1px solid #f3d2cf}
.message.success{background:var(--ok-bg);color:var(--ok);border:1px solid #d6e5da}

/* OTP */
.otp-form{width:100%}
.code-row{display:flex;gap:9px;margin-bottom:16px}
.otp-digit{width:46px;height:54px;text-align:center;font-size:1.3rem;border:1.5px solid var(--line);border-radius:8px;background:var(--surface);color:var(--slate-900);transition:border-color .2s,box-shadow .2s}
.otp-digit:focus{outline:none;border-color:var(--navy);box-shadow:0 0 0 3px rgba(30,58,95,.12)}
.otp-digit:disabled{opacity:.4}
.timer-row{display:flex;align-items:center;justify-content:space-between;font-size:.85rem;color:var(--slate-500);margin-bottom:22px}
.timer-row strong{color:var(--navy);font-variant-numeric:tabular-nums}

.qr-wrap{display:flex;gap:16px;align-items:center;margin-bottom:24px;padding:14px;border:1px solid var(--line);border-radius:12px;background:var(--bg)}
.qr-box{background:#fff;padding:8px;border-radius:8px;flex-shrink:0}
.qr-box img{width:104px;height:104px;display:block}
.qr-note{display:flex;flex-direction:column;gap:4px}
.qr-note strong{color:var(--navy);font-size:.85rem}
.qr-note span{font-size:.8rem;color:var(--slate-500);line-height:1.45}
.qr-key{font-size:.72rem;font-family:ui-monospace,monospace;color:var(--navy);background:var(--surface);border:1px dashed var(--line);border-radius:6px;padding:6px 8px;word-break:break-all;letter-spacing:.03em}
.verify-hint{font-size:.82rem;color:var(--slate-500);margin:-8px 0 16px}

/* Loader de verificacion */
.loader{display:none;justify-content:center;margin-top:18px}
.loader.is-visible{display:flex}
.loader-ring{width:22px;height:22px;border:2px solid var(--line);border-top-color:var(--navy);border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

@media(max-width:860px){
    .auth-wrap{grid-template-columns:1fr}
    .brand-panel{display:none}
    .form-panel{padding:56px 24px;min-height:100vh}
}
@media (prefers-reduced-motion:reduce){*{animation-duration:.001ms !important;transition-duration:.001ms !important}}
</style>

<script>
(function(){
    // Mostrar / ocultar contraseña (ojo)
    document.querySelectorAll('[data-toggle-password]').forEach(function(btn){
        btn.addEventListener('click', function(){
            var input = document.getElementById(btn.getAttribute('data-toggle-password'));
            if(!input) return;
            var esTexto = input.type === 'text';
            input.type = esTexto ? 'password' : 'text';
            btn.setAttribute('aria-label', esTexto ? 'Mostrar contraseña' : 'Ocultar contraseña');
            var open = btn.querySelector('.eye-open');
            var closed = btn.querySelector('.eye-closed');
            if(open) open.style.display = esTexto ? '' : 'none';
            if(closed) closed.style.display = esTexto ? 'none' : '';
        });
    });

    // Cambiar paso
    function show(name){
        document.querySelectorAll('.step').forEach(function(p){ p.classList.remove('is-active'); });
        var el = document.querySelector('[data-step="'+name+'"]');
        if(el){ el.classList.add('is-active'); }
    }
    document.querySelectorAll('[data-goto]').forEach(function(el){
        el.addEventListener('click', function(e){ e.preventDefault(); show(el.getAttribute('data-goto')); });
    });

    // OTP: concatenar y mover
    var digits = document.querySelectorAll('.otp-digit');
    var hidden = document.getElementById('otp-hidden');
    if(digits.length){
        digits.forEach(function(input, i){
            input.addEventListener('input', function(){
                input.value = input.value.replace(/[^0-9]/g,'').slice(0,1);
                updateHidden();
                if(input.value && i < digits.length-1){ digits[i+1].focus(); }
            });
            input.addEventListener('keydown', function(e){
                if(e.key === 'Backspace' && !input.value && i>0){ digits[i-1].focus(); }
            });
        });
    }
    function updateHidden(){ hidden.value = Array.from(digits).map(function(d){ return d.value; }).join(''); }

    // Timer 30s
    var timerEl = document.querySelector('[data-role="timer"]');
    if(timerEl){
        var left = 30;
        setInterval(function(){
            left--;
            if(left>=0){ timerEl.textContent = '0:'+(left<10?'0':'')+left; }
        },1000);
    }

    // Loader en el boton de verificar
    var verifyForm = document.querySelector('.otp-form');
    if(verifyForm){
        verifyForm.addEventListener('submit', function(){
            var loader = document.querySelector('[data-role="loader"]');
            var btn = verifyForm.querySelector('[data-role="verify-btn"]');
            if(loader){ loader.classList.add('is-visible'); }
            if(btn){ btn.disabled = true; }
        });
    }

    // Loading en el boton de acceder (evita doble envio)
    var loginForm = document.querySelector('[data-step="login"]');
    if(loginForm){
        loginForm.addEventListener('submit', function(){
            var btn = loginForm.querySelector('[data-role="login-btn"]');
            if(btn && !btn.disabled){ btn.classList.add('is-loading'); btn.disabled = true; }
        });
    }
})();
</script>
@endsection