@extends('layouts.app')

@section('title', 'Masuk ke Portal')

@section('content')

<div class="container" style="max-width: 480px; padding: 70px 20px 100px;">
    <div style="background: white; border-radius: 24px; padding: 40px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-elevated);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, var(--maroon-primary), var(--maroon-deep)); border: 2px solid var(--gold-primary); display: inline-flex; align-items: center; justify-content: center; color: var(--gold-light); font-size: 1.3rem; font-family: var(--font-display); font-weight: 700; margin-bottom: 12px;">
                HA
            </div>
            <h1 style="font-family: var(--font-display); font-size: 1.6rem; color: var(--slate-900);">Masuk ke Portal</h1>
            <p style="color: var(--text-muted); font-size: 0.88rem;">Pintu masuk Tim Redaksi & Alumni Hatta Muda Connection</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom: 20px;">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--slate-800); margin-bottom: 6px;">Alamat Email</label>
                <input type="email" name="email" id="login_email" value="{{ old('email') }}" required class="form-control" style="width:100%; padding:11px 14px; border-radius:8px; border:1px solid var(--border-subtle); font-size:0.92rem;" placeholder="nama@domain.com">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--slate-800); margin-bottom: 6px;">Kata Sandi</label>
                <input type="password" name="password" id="login_password" required class="form-control" style="width:100%; padding:11px 14px; border-radius:8px; border:1px solid var(--border-subtle); font-size:0.92rem;" placeholder="••••••••">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 0.84rem;">
                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; color:#64748b;">
                    <input type="checkbox" name="remember"> Ingat Saya
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 0.95rem; border-radius: 8px;">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Sekarang
            </button>
        </form>

        <!-- Quick Demo Credentials Box -->
        <div style="margin-top: 30px; padding: 18px; background: #f8fafc; border-radius: 12px; border: 1px dashed var(--border-subtle); font-size: 0.82rem;">
            <strong style="color: var(--slate-900); display: block; margin-bottom: 8px;"><i class="fa-solid fa-key" style="color:var(--gold-dark);"></i> Akses Demo Akun:</strong>
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span><strong>Admin:</strong> admin@hattaaksara.id (password)</span>
                    <button type="button" onclick="fillCreds('admin@hattaaksara.id', 'password')" class="btn btn-outline" style="padding:2px 8px; font-size:0.72rem;">Isi</button>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span><strong>Alumni:</strong> ahmad.fauzan@alumni.hattaaksara.id (password)</span>
                    <button type="button" onclick="fillCreds('ahmad.fauzan@alumni.hattaaksara.id', 'password')" class="btn btn-outline" style="padding:2px 8px; font-size:0.72rem;">Isi</button>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 24px; font-size: 0.88rem; color: var(--text-muted);">
            Alumni ISLT baru? <a href="{{ route('register.hatta-muda') }}" style="color: var(--maroon-primary); font-weight: 700;">Daftar Akun Hatta Muda</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function fillCreds(email, password) {
        document.getElementById('login_email').value = email;
        document.getElementById('login_password').value = password;
    }
</script>
@endpush

@endsection
