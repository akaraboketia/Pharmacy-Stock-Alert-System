@extends('layouts.guest')

@section('title', 'Forgot Password - Pharmacy Stock Alert System')

@section('content')
<div class="container-fluid p-0" style="min-height:100vh;">
    <div class="row g-0 min-vh-100">
        <!-- Left: Illustration (hidden on mobile) -->
        <div class="col-lg-6 d-none d-lg-flex flex-column align-items-center justify-content-center p-5" style="background:linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);position:relative;overflow:hidden;">
            <div style="position:absolute;top:-100px;right:-100px;width:350px;height:350px;border-radius:50%;background:rgba(37,99,235,0.08);"></div>
            <div style="position:absolute;bottom:-80px;left:-80px;width:300px;height:300px;border-radius:50%;background:rgba(37,99,235,0.05);"></div>
            <div class="text-center" style="position:relative;z-index:1;">
                <div class="d-inline-flex align-items-center justify-content-center mb-4"
                    style="width:72px;height:72px;border-radius:18px;background:linear-gradient(135deg,#2563eb,#1e40af);box-shadow:0 8px 32px rgba(37,99,235,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                </div>
                <h2 class="text-white fw-bold mb-2" style="font-size:1.8rem;">Reset your password</h2>
                <p class="text-white-50" style="font-size:0.9rem;max-width:320px;line-height:1.6;">
                    Enter your username and we'll help you create a new password to regain access to your account.
                </p>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center p-4" style="background:#f8fafc;min-height:100vh;">
            <div class="w-100" style="max-width:400px;">
                <!-- Mobile back -->
                <div class="d-lg-none mb-3">
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none" style="font-size:0.85rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Back to sign in
                    </a>
                </div>

                <div class="mb-4">
                    <h3 class="fw-bold mb-1" style="font-size:1.4rem;">Forgot password?</h3>
                    <p class="text-muted" style="font-size:0.85rem;">No worries, we'll help you reset it.</p>
                </div>

                <div class="card" style="border:none;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,0.06),0 1px 2px rgba(0,0,0,0.04);">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                            @csrf
                            <div class="mb-4">
                                <label for="username" class="form-label fw-semibold" style="font-size:0.85rem;">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username') }}"
                                        required autofocus placeholder="Enter your username"
                                        style="border-left:none;">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($errors->has('username'))
                                    <div class="text-danger mt-1" style="font-size:0.75rem;">{{ $errors->first('username') }}</div>
                                @endif
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-semibold" id="submitBtn" style="padding:0.7rem 1rem;border-radius:12px;">
                                    <span class="btn-text"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Send Reset Link</span>
                                    <span class="btn-loading d-none">
                                        <span class="spinner-border spinner-border-sm me-2"></span> Sending...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-primary text-decoration-none" style="font-size:0.85rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Back to sign in
                    </a>
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
document.getElementById('forgotForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.querySelector('.btn-text').classList.add('d-none');
    btn.querySelector('.btn-loading').classList.remove('d-none');
});
</script>
@endpush
