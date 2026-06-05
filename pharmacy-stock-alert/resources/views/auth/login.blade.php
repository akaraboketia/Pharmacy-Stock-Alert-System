@extends('layouts.guest')

@section('title', 'Sign In - Pharmacy Stock Alert System')

@section('content')
<div class="container-fluid p-0" style="min-height:100vh;">
    <div class="row g-0 min-vh-100">
        <!-- Left Side: Medical Illustration -->
        <div class="col-lg-6 d-none d-lg-flex flex-column" style="background:linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);position:relative;overflow:hidden;">
            <!-- Decorative elements -->
            <div style="position:absolute;top:-80px;right:-80px;width:300px;height:300px;border-radius:50%;background:rgba(37,99,235,0.08);"></div>
            <div style="position:absolute;bottom:-120px;left:-60px;width:400px;height:400px;border-radius:50%;background:rgba(37,99,235,0.05);"></div>
            <div style="position:absolute;top:40%;left:10%;width:120px;height:120px;border-radius:50%;background:rgba(37,99,235,0.06);"></div>

            <!-- Animated medical icons -->
            <div style="position:absolute;top:15%;right:15%;font-size:2rem;color:rgba(37,99,235,0.25);animation:floatIcon 6s ease-in-out infinite;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
            </div>
            <div style="position:absolute;bottom:25%;left:10%;font-size:3rem;color:rgba(37,99,235,0.2);animation:floatIcon 8s ease-in-out infinite 1s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.5-2 4-4.5 4-7A4.5 4.5 0 0 0 15.5 5c-1.5 0-2.9.7-3.5 1.8A4.5 4.5 0 0 0 5 7c0 2.5 2.5 5 4 7l3 3 3-3z"/><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div style="position:absolute;top:35%;left:60%;font-size:1.5rem;color:rgba(37,99,235,0.22);animation:floatIcon 7s ease-in-out infinite 0.5s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a6 6 0 0 1-6-6c0-4 6-10 6-10s6 6 6 10a6 6 0 0 1-6 6z"/></svg>
            </div>
            <div style="position:absolute;bottom:40%;right:20%;font-size:2rem;color:rgba(37,99,235,0.2);animation:floatIcon 9s ease-in-out infinite 2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="10" rx="2"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="8" y1="27" x2="8" y2="-3"/></svg>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center h-100 px-5" style="position:relative;z-index:1;">
                <!-- Brand -->
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4"
                        style="width:80px;height:80px;border-radius:20px;background:linear-gradient(135deg,#2563eb,#1e40af);box-shadow:0 8px 32px rgba(37,99,235,0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
                    </div>
                    <h2 class="text-white fw-bold mb-2" style="font-size:2rem;letter-spacing:-0.5px;">PharmaAlert</h2>
                    <p class="text-white-50 mb-0" style="font-size:0.95rem;max-width:360px;line-height:1.6;">
                        Enterprise-grade pharmacy stock management platform designed for hospitals and large pharmacies.
                    </p>
                </div>

                <!-- Feature cards -->
                <div style="max-width:400px;width:100%;">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(10px);">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(37,99,235,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                        </div>
                        <div>
                            <div style="font-size:0.85rem;font-weight:600;color:#fff;">Real-time Stock Monitoring</div>
                            <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Instant alerts for low stock, expiring, and expired medicines</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(10px);">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(37,99,235,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                        <div>
                            <div style="font-size:0.85rem;font-weight:600;color:#fff;">Analytics & Reports</div>
                            <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Interactive charts and insights to optimize inventory</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(10px);">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(37,99,235,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div>
                            <div style="font-size:0.85rem;font-weight:600;color:#fff;">Multi-role Access</div>
                            <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Role-based dashboards for admin, pharmacist, and staff</div>
                        </div>
                    </div>
                </div>

                <!-- Location badge -->
                <div class="mt-4 pt-3 text-center" style="border-top:1px solid rgba(255,255,255,0.06);width:100%;max-width:400px;">
                    <p class="mb-0" style="font-size:0.8rem;color:rgba(255,255,255,0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Nyarugenge District, Kigali — Rwanda
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center p-4" style="background:#f8fafc;min-height:100vh;">
            <div class="w-100" style="max-width:400px;">
                <!-- Mobile logo -->
                <div class="text-center d-lg-none mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:64px;height:64px;border-radius:16px;background:linear-gradient(135deg,#2563eb,#1e40af);box-shadow:0 4px 16px rgba(37,99,235,0.25);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
                    </div>
                    <h4 class="fw-bold mb-1">PharmaAlert</h4>
                    <p class="text-muted" style="font-size:0.85rem;">Nyarugenge District, Kigali — Rwanda</p>
                </div>

                <!-- Header -->
                <div class="mb-4">
                    <h3 class="fw-bold mb-1" style="font-size:1.5rem;">Welcome back</h3>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">Sign in to your account to continue</p>
                </div>

                <!-- Login form -->
                <div class="card" style="border:none;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,0.06),0 1px 2px rgba(0,0,0,0.04);">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <!-- Role selector -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold" style="font-size:0.8rem;">Select Role</label>
                                @error('role')
                                    <div class="invalid-feedback d-block mb-1" style="font-size:0.75rem;">{{ $message }}</div>
                                @enderror
                                <div class="d-flex gap-2" id="roleSelector">
                                    <label class="role-option flex-fill {{ old('role', '') === 'admin' ? 'active' : '' }}">
                                        <input type="radio" name="role" value="admin" {{ old('role', '') === 'admin' ? 'checked' : '' }} class="d-none">
                                        <div class="role-card text-center p-2 rounded-3" style="cursor:pointer;transition:all 0.2s ease;border:2px solid transparent;">
                                            <div class="role-icon mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><rect x="9" y="11" width="6" height="4" rx="1"/><line x1="12" y1="7" x2="12" y2="11"/></svg>
                                            </div>
                                            <div style="font-size:0.75rem;font-weight:600;">Admin</div>
                                        </div>
                                    </label>
                                    <label class="role-option flex-fill {{ old('role', '') === 'pharmacist' ? 'active' : '' }}">
                                        <input type="radio" name="role" value="pharmacist" {{ old('role', '') === 'pharmacist' ? 'checked' : '' }} class="d-none">
                                        <div class="role-card text-center p-2 rounded-3" style="cursor:pointer;transition:all 0.2s ease;border:2px solid transparent;">
                                            <div class="role-icon mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
                                            </div>
                                            <div style="font-size:0.75rem;font-weight:600;">Pharmacist</div>
                                        </div>
                                    </label>
                                    <label class="role-option flex-fill {{ old('role', '') === 'staff' ? 'active' : '' }}">
                                        <input type="radio" name="role" value="staff" {{ old('role', '') === 'staff' ? 'checked' : '' }} class="d-none">
                                        <div class="role-card text-center p-2 rounded-3" style="cursor:pointer;transition:all 0.2s ease;border:2px solid transparent;">
                                            <div class="role-icon mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M12 11v5"/><path d="M9 14l3 3 3-3"/></svg>
                                            </div>
                                            <div style="font-size:0.75rem;font-weight:600;">Staff</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
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
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-semibold" style="font-size:0.85rem;margin-bottom:0;">Password</label>
                                    <a href="{{ route('password.request') }}" class="text-primary" style="font-size:0.75rem;text-decoration:none;">
                                        Forgot password?
                                    </a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required placeholder="Enter your password"
                                        style="border-left:none;">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember" style="font-size:0.85rem;color:var(--text-secondary);">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold" id="loginBtn" style="padding:0.7rem 1rem;border-radius:12px;">
                                    <span class="btn-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg> Sign In</span>
                                    <span class="btn-loading d-none">
                                        <span class="spinner-border spinner-border-sm me-2"></span> Signing in...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick hints -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-1" style="font-size:0.75rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Demo accounts — Select matching role below
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap" style="font-size:0.75rem;">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><rect x="9" y="11" width="6" height="4" rx="1"/><line x1="12" y1="7" x2="12" y2="11"/></svg> <strong>admin</strong> / admin123
                        </span>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg> <strong>pharmacist</strong> / pharm123
                        </span>
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M12 11v5"/><path d="M9 14l3 3 3-3"/></svg> <strong>staff</strong> / staff123
                        </span>
                    </div>
                </div>

                <p class="text-center text-muted mt-3" style="font-size:0.75rem;">
                    Pharmacy Stock Alert System &copy; {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Loading overlay -->
<div id="loginOverlay" class="d-none" style="position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;">
    <div class="text-center">
        <div class="spinner-border text-primary mb-3" role="status" style="width:3rem;height:3rem;"></div>
        <p class="text-white fw-semibold" style="font-size:1rem;">Signing in...</p>
    </div>
</div>

<style>
    @keyframes floatIcon {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .role-option .role-card {
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
    }
    .role-option .role-card:hover {
        border-color: #93c5fd;
        background: #eff6ff;
        color: #2563eb;
    }
    .role-option.active .role-card {
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
    }
    .role-option.active .role-icon i { color: #2563eb; }

    .input-group:focus-within .input-group-text {
        border-color: #2563eb;
    }
    .input-group-text {
        background: #f8fafc;
        color: #94a3b8;
        border: 1.5px solid #e2e8f0;
        border-right: none;
        border-radius: 12px 0 0 12px;
    }
    .input-group .form-control {
        border: 1.5px solid #e2e8f0;
        border-left: none;
        border-radius: 0 12px 12px 0;
    }
    .input-group .form-control:focus {
        border-color: #2563eb;
        box-shadow: none;
    }
    .input-group:focus-within .input-group-text {
        border-color: #2563eb;
    }

    .form-check-input:checked {
        background-color: #2563eb;
        border-color: #2563eb;
    }

    /* Error state for form */
    .form-control.is-invalid {
        border-color: #dc2626;
    }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Role selector handling
    document.querySelectorAll('.role-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.role-option').forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            this.querySelector('input[type="radio"]').checked = true;
        });
    });

    // Login form submission with loading animation
    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        const btn = document.getElementById('loginBtn');
        btn.disabled = true;
        btn.querySelector('.btn-text').classList.add('d-none');
        btn.querySelector('.btn-loading').classList.remove('d-none');

        // Show overlay after brief delay
        setTimeout(() => {
            document.getElementById('loginOverlay').classList.remove('d-none');
        }, 300);
    });

    // Auto-focus username field
    const usernameField = document.getElementById('username');
    if (usernameField && !usernameField.value) {
        usernameField.focus();
    }

    // Auto-submit role selection from URL params (for demo convenience)
    const params = new URLSearchParams(window.location.search);
    const roleParam = params.get('role');
    if (roleParam) {
        const radio = document.querySelector(`.role-option input[value="${roleParam}"]`);
        if (radio) {
            radio.checked = true;
            radio.closest('.role-option').click();
        }
    }
});
</script>
@endpush
