@extends('layouts.guest')

@section('title', 'Reset Password - Pharmacy Stock Alert System')

@section('content')
<div class="container-fluid p-0" style="min-height:100vh;">
    <div class="row g-0 min-vh-100">
        <div class="col-lg-6 d-none d-lg-flex flex-column align-items-center justify-content-center p-5" style="background:linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);position:relative;overflow:hidden;">
            <div style="position:absolute;top:-80px;right:-80px;width:300px;height:300px;border-radius:50%;background:rgba(37,99,235,0.08);"></div>
            <div style="position:absolute;bottom:-100px;left:-60px;width:350px;height:350px;border-radius:50%;background:rgba(37,99,235,0.05);"></div>
            <div class="text-center" style="position:relative;z-index:1;">
                <div class="d-inline-flex align-items-center justify-content-center mb-4"
                    style="width:72px;height:72px;border-radius:18px;background:linear-gradient(135deg,#2563eb,#1e40af);box-shadow:0 8px 32px rgba(37,99,235,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                </div>
                <h2 class="text-white fw-bold mb-2" style="font-size:1.8rem;">Create new password</h2>
                <p class="text-white-50" style="font-size:0.9rem;max-width:320px;line-height:1.6;">
                    Your new password must be different from previously used passwords.
                </p>
            </div>
        </div>

        <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center p-4" style="background:#f8fafc;min-height:100vh;">
            <div class="w-100" style="max-width:400px;">
                <div class="d-lg-none mb-3">
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none" style="font-size:0.85rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Back to sign in
                    </a>
                </div>

                <div class="mb-4">
                    <h3 class="fw-bold mb-1" style="font-size:1.4rem;">Set new password</h3>
                    <p class="text-muted" style="font-size:0.85rem;">Must be at least 6 characters.</p>
                </div>

                <div class="card" style="border:none;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,0.06),0 1px 2px rgba(0,0,0,0.04);">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="username" value="{{ $username }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                                    <input type="text" class="form-control" value="{{ $username }}" disabled style="border-left:none;background:#f8fafc;color:#64748b;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold" style="font-size:0.85rem;">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required minlength="6"
                                        placeholder="Enter new password" style="border-left:none;">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold" style="font-size:0.85rem;">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                                    <input type="password" class="form-control"
                                        id="password_confirmation" name="password_confirmation" required minlength="6"
                                        placeholder="Confirm new password" style="border-left:none;">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-semibold" id="submitBtn" style="padding:0.7rem 1rem;border-radius:12px;">
                                    <span class="btn-text"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><polyline points="20 6 9 17 4 12"/></svg> Reset Password</span>
                                    <span class="btn-loading d-none">
                                        <span class="spinner-border spinner-border-sm me-2"></span> Resetting...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group:focus-within .input-group-text { border-color: #2563eb; }
    .input-group-text {
        background: #f8fafc; color: #94a3b8;
        border: 1.5px solid #e2e8f0; border-right: none;
        border-radius: 12px 0 0 12px;
    }
    .input-group .form-control {
        border: 1.5px solid #e2e8f0; border-left: none;
        border-radius: 0 12px 12px 0;
    }
    .input-group .form-control:focus { border-color: #2563eb; box-shadow: none; }
</style>
@endsection

@push('scripts')
<script>
document.getElementById('resetForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.querySelector('.btn-text').classList.add('d-none');
    btn.querySelector('.btn-loading').classList.remove('d-none');
});
</script>
@endpush
