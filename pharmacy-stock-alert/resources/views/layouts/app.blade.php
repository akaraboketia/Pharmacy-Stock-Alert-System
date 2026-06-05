<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pharmacy Stock Alert System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <style>
        /* ==============================
           CSS VARIABLES & THEMING
           ============================== */
        :root {
            --sidebar-width: 270px;
            --sidebar-collapsed: 0px;
            --topbar-height: 64px;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #dbeafe;
            --primary-50: #eff6ff;
            --danger: #dc2626;
            --danger-light: #fee2e2;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --success: #16a34a;
            --success-light: #dcfce7;
            --info: #0891b2;
            --info-light: #cffafe;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: var(--primary);
            --card-radius: 16px;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --card-shadow-hover: 0 10px 30px rgba(0,0,0,0.08), 0 4px 10px rgba(0,0,0,0.04);
            --transition-base: 0.2s ease;
            --transition-smooth: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            --bg-body: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }

        /* ==============================
           RESET & BASE
           ============================== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: var(--font-family);
            background: var(--bg-body);
            min-height: 100vh;
            color: var(--text-primary);
        }

        /* ==============================
           SIDEBAR
           ============================== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1040;
            transition: transform var(--transition-smooth);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .sidebar .brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            gap: 0.75rem;
            flex-shrink: 0;
        }
        .sidebar .brand .brand-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), #1e40af);
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar .brand .brand-icon svg { width: 22px; height: 22px; color: #fff; flex-shrink: 0; }
        .sidebar .brand .brand-text { }
        .sidebar .brand .brand-text .brand-name { font-size: 1rem; font-weight: 700; color: #fff; letter-spacing: 0.3px; display: block; line-height: 1.2; }
        .sidebar .brand .brand-text .brand-sub { font-size: 0.65rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.5px; }

        .sidebar .nav-section {
            padding: 1.25rem 1.25rem 0.5rem;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.25);
            font-weight: 600;
        }

        .sidebar .nav-item { margin: 0.1rem 0.6rem; }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.85rem;
            border-radius: 0.5rem;
            color: rgba(255,255,255,0.55);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all var(--transition-base);
            position: relative;
        }
        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: rgba(255,255,255,0.9);
        }
        .sidebar .nav-link.active {
            background: var(--sidebar-active);
            color: #fff;
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }
        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 1.25rem;
            text-align: center;
            flex-shrink: 0;
        }
        .sidebar .nav-link .nav-badge {
            margin-left: auto;
            font-size: 0.65rem;
            padding: 0.1rem 0.5rem;
            border-radius: 1rem;
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
        }
        .sidebar .nav-link.active .nav-badge {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        .sidebar .sidebar-nav { flex: 1; padding-bottom: 1rem; }

        .sidebar .sidebar-footer {
            padding: 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .sidebar .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.85rem;
            border-radius: 0.5rem;
            color: rgba(255,255,255,0.4);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all var(--transition-base);
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }
        .sidebar .logout-btn:hover { background: rgba(220,38,38,0.12); color: #ef4444; }
        .sidebar .logout-btn i { font-size: 1.1rem; width: 1.25rem; text-align: center; }

        /* ==============================
           TOPBAR
           ============================== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left var(--transition-smooth);
        }
        .topbar {
            height: var(--topbar-height);
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .topbar .page-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .topbar .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .topbar .btn-icon {
            width: 38px; height: 38px; border-radius: 10px;
            border: none; background: transparent;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.15rem; color: var(--text-secondary);
            transition: all var(--transition-base); position: relative;
            cursor: pointer;
        }
        .topbar .btn-icon:hover { background: var(--primary-50); color: var(--primary); }
        .topbar .btn-icon .badge-dot {
            position: absolute; top: 6px; right: 6px;
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--danger);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.3); }
        }

        .user-dropdown-toggle {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.3rem 0.6rem 0.3rem 0.3rem;
            border-radius: 2rem;
            border: 1px solid var(--border-color);
            cursor: pointer; transition: all var(--transition-base);
            background: #fff; text-decoration: none; color: inherit;
        }
        .user-dropdown-toggle:hover {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        .user-dropdown-toggle .avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #1e40af);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 0.8rem;
        }
        .user-dropdown-toggle .user-name { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); }
        .user-dropdown-toggle .dropdown-arrow { font-size: 0.65rem; color: var(--text-secondary); }

        /* ==============================
           CONTENT AREA
           ============================== */
        .content-wrapper {
            padding: 1.5rem;
            animation: fadeInUp 0.4s ease;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ==============================
           STAT CARDS
           ============================== */
        .stat-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-smooth);
            overflow: hidden;
            position: relative;
            cursor: default;
            animation: fadeInUp 0.5s ease both;
        }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.2s; }
        .stat-card:nth-child(5) { animation-delay: 0.25s; }
        .stat-card:nth-child(6) { animation-delay: 0.3s; }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }
        .stat-card .card-body { padding: 1.25rem; }
        .stat-card .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .stat-card .stat-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .stat-card .stat-trend {
            font-size: 0.7rem;
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
            padding: 0.15rem 0.5rem;
            border-radius: 1rem;
            font-weight: 600;
        }
        .stat-card .stat-trend.up { background: var(--success-light); color: var(--success); }
        .stat-card .stat-trend.down { background: var(--danger-light); color: var(--danger); }
        .stat-card .stat-trend.neutral { background: var(--primary-light); color: var(--primary); }

        /* ==============================
           CUSTOM CARDS
           ============================== */
        .card-custom {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            animation: fadeInUp 0.5s ease both;
        }
        .card-custom .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .card-custom .card-footer {
            background: transparent;
            border-top: 1px solid var(--border-color);
            padding: 0.75rem 1.25rem;
        }

        /* ==============================
           TABLES
           ============================== */
        .table-custom {
            margin-bottom: 0;
        }
        .table-custom thead th {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            border-bottom-width: 1px;
            border-bottom-color: var(--border-color);
            padding: 0.75rem 1rem;
            background: rgba(0,0,0,0.01);
        }
        .table-custom tbody td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            border-bottom-color: var(--border-color);
        }
        .table-custom tbody tr {
            transition: background var(--transition-base);
        }
        .table-custom tbody tr:hover {
            background: var(--primary-50);
        }
        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        /* ==============================
           BADGES
           ============================== */
        .badge-status {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .badge-expired { background: var(--danger-light); color: var(--danger); }
        .badge-expiring { background: var(--warning-light); color: #d97706; }
        .badge-lowstock { background: #fef2f2; color: #b91c1c; }
        .badge-good { background: var(--success-light); color: var(--success); }
        .badge-info { background: var(--info-light); color: var(--info); }

        /* ==============================
           ALERTS PANEL
           ============================== */
        .alert-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            transition: all var(--transition-base);
            border-left: 3px solid transparent;
            margin-bottom: 0.25rem;
        }
        .alert-item:hover {
            background: var(--primary-50);
        }
        .alert-item.critical {
            border-left-color: var(--danger);
            background: linear-gradient(135deg, #fef2f2, #fff);
        }
        .alert-item.critical:hover { background: #fee2e2; }
        .alert-item.warning {
            border-left-color: var(--warning);
            background: linear-gradient(135deg, #fffbeb, #fff);
        }
        .alert-item.warning:hover { background: #fef3c7; }
        .alert-item.info {
            border-left-color: var(--primary);
            background: linear-gradient(135deg, var(--primary-50), #fff);
        }
        .alert-item.info:hover { background: var(--primary-light); }

        .alert-item .alert-icon {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .alert-item.critical .alert-icon { background: var(--danger-light); color: var(--danger); }
        .alert-item.warning .alert-icon { background: var(--warning-light); color: #d97706; }
        .alert-item.info .alert-icon { background: var(--primary-light); color: var(--primary); }

        .alert-item .alert-content { flex: 1; min-width: 0; }
        .alert-item .alert-title { font-size: 0.85rem; font-weight: 600; }
        .alert-item .alert-desc { font-size: 0.75rem; color: var(--text-secondary); }
        .alert-item .alert-time { font-size: 0.65rem; color: var(--text-secondary); white-space: nowrap; }

        .critical-pulse {
            animation: criticalPulse 2s infinite;
        }
        @keyframes criticalPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(220,38,38,0.3); }
            50% { box-shadow: 0 0 0 8px rgba(220,38,38,0); }
        }

        /* ==============================
           FORMS
           ============================== */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            padding: 0.55rem 0.85rem;
            font-size: 0.875rem;
            transition: all var(--transition-base);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 1.5px solid var(--border-color);
            background: #f8fafc;
            color: var(--text-secondary);
        }
        .input-group > .form-control {
            border-radius: 0 10px 10px 0;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--primary);
        }

        /* ==============================
           BUTTONS
           ============================== */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            transition: all var(--transition-base);
        }
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }
        .btn-sm {
            border-radius: 8px;
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }
        .btn-icon-sm {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        /* ==============================
           PAGINATION
           ============================== */
        .pagination {
            gap: 0.2rem;
        }
        .pagination .page-link {
            border-radius: 8px !important;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 0.8rem;
            padding: 0.4rem 0.75rem;
            transition: all var(--transition-base);
        }
        .pagination .page-link:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-50);
        }
        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }
        .pagination .page-item.disabled .page-link {
            background: #f1f5f9;
            color: #94a3b8;
        }

        /* ==============================
           ICON SIZING - Inline SVGs use explicit width/height attributes
           ============================== */
        .sidebar svg, .topbar svg, .stat-card svg { flex-shrink: 0; }

        /* ==============================
           SKELETON LOADING
           ============================== */
        .skeleton {
            background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 6px;
        }
        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ==============================
           STATUS PILLS
           ============================== */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.65rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pill .status-dot {
            width: 6px; height: 6px; border-radius: 50%;
        }
        .status-pill.pill-expired { background: #fef2f2; color: #b91c1c; }
        .status-pill.pill-expired .status-dot { background: #dc2626; }
        .status-pill.pill-expiring { background: #fffbeb; color: #b45309; }
        .status-pill.pill-expiring .status-dot { background: #f59e0b; }
        .status-pill.pill-lowstock { background: #fff1f2; color: #be123c; }
        .status-pill.pill-lowstock .status-dot { background: #e11d48; }
        .status-pill.pill-good { background: #f0fdf4; color: #15803d; }
        .status-pill.pill-good .status-dot { background: #22c55e; }

        /* ==============================
           RESPONSIVE
           ============================== */
        .sidebar-overlay { display: none; }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .sidebar-overlay.show {
                display: block;
                position: fixed; inset: 0;
                background: rgba(0,0,0,0.5);
                backdrop-filter: blur(4px);
                z-index: 1035;
                animation: fadeIn 0.2s ease;
            }
            .main-content { margin-left: 0; }
        }

        /* ==============================
           GLASSMORPHISM EFFECTS
           ============================== */
        .glass-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 32px rgba(0,0,0,0.06);
        }
        .glass-card:hover {
            background: rgba(255,255,255,0.85);
            box-shadow: 0 12px 40px rgba(0,0,0,0.1);
        }
        .glass-sidebar {
            background: rgba(15,23,42,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255,255,255,0.06);
        }
        .glass-topbar {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226,232,240,0.5);
        }
        .glass-modal {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .shimmer {
            background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, transparent 50%);
            pointer-events: none;
            border-radius: inherit;
        }
        .card-custom {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* ==============================
           DARK MODE
           ============================== */
        [data-bs-theme="dark"] {
            --bg-body: #0f172a;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --border-color: #1e293b;
        }
        [data-bs-theme="dark"] .topbar {
            background: rgba(15,23,42,0.9);
            backdrop-filter: blur(12px);
            border-color: #1e293b;
        }
        [data-bs-theme="dark"] .topbar .page-title { color: #e2e8f0; }
        [data-bs-theme="dark"] .topbar .btn-icon { color: #94a3b8; }
        [data-bs-theme="dark"] .topbar .btn-icon:hover { background: #1e293b; color: var(--primary); }
        [data-bs-theme="dark"] .user-dropdown-toggle { background: #1e293b; border-color: #334155; }
        [data-bs-theme="dark"] .user-dropdown-toggle .user-name { color: #e2e8f0; }
        [data-bs-theme="dark"] .glass-card {
            background: rgba(30,41,59,0.7);
            border: 1px solid rgba(255,255,255,0.06);
        }
        [data-bs-theme="dark"] .glass-card:hover { background: rgba(30,41,59,0.85); }
        [data-bs-theme="dark"] .glass-topbar {
            background: rgba(15,23,42,0.8);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        [data-bs-theme="dark"] .glass-sidebar {
            background: rgba(15,23,42,0.9);
        }
        [data-bs-theme="dark"] .card-custom {
            background: rgba(30,41,59,0.85);
            backdrop-filter: blur(12px);
        }
        [data-bs-theme="dark"] .card-custom .card-header { border-color: #334155; color: #e2e8f0; }
        [data-bs-theme="dark"] .table-custom { color: #e2e8f0; }
        [data-bs-theme="dark"] .table-custom thead th { color: #94a3b8; border-color: #334155; background: rgba(0,0,0,0.2); }
        [data-bs-theme="dark"] .table-custom tbody td { border-color: #334155; }
        [data-bs-theme="dark"] .table-custom tbody tr:hover { background: #0f172a; }
        [data-bs-theme="dark"] .stat-card { background: #1e293b; }
        [data-bs-theme="dark"] .stat-card .stat-label { color: #94a3b8; }
        [data-bs-theme="dark"] .alert-item.critical { background: rgba(220,38,38,0.1); }
        [data-bs-theme="dark"] .alert-item.warning { background: rgba(245,158,11,0.1); }
        [data-bs-theme="dark"] .alert-item.info { background: rgba(37,99,235,0.1); }
        [data-bs-theme="dark"] .alert-item.critical:hover { background: rgba(220,38,38,0.15); }
        [data-bs-theme="dark"] .alert-item.warning:hover { background: rgba(245,158,11,0.15); }
        [data-bs-theme="dark"] .alert-item.info:hover { background: rgba(37,99,235,0.15); }
        [data-bs-theme="dark"] .modal-content { background: #1e293b; color: #e2e8f0; }
        [data-bs-theme="dark"] .modal-header, [data-bs-theme="dark"] .modal-footer { border-color: #334155; }
        [data-bs-theme="dark"] .form-control, [data-bs-theme="dark"] .form-select {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .form-control:focus, [data-bs-theme="dark"] .form-select:focus {
            background: #0f172a;
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .input-group-text {
            background: #1e293b;
            border-color: #334155;
            color: #94a3b8;
        }
        [data-bs-theme="dark"] .alert { background: #1e293b; color: #e2e8f0; border: none; }
        [data-bs-theme="dark"] .pagination .page-link {
            background: #1e293b;
            border-color: #334155;
            color: #94a3b8;
        }
        [data-bs-theme="dark"] .pagination .page-link:hover {
            background: #0f172a;
            border-color: var(--primary);
            color: var(--primary);
        }
        [data-bs-theme="dark"] .pagination .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }
        [data-bs-theme="dark"] .pagination .page-item.disabled .page-link { background: #0f172a; color: #475569; }
        [data-bs-theme="dark"] .dropdown-menu {
            background: #1e293b;
            border-color: #334155;
        }
        [data-bs-theme="dark"] .dropdown-item { color: #e2e8f0; }
        [data-bs-theme="dark"] .dropdown-item:hover { background: #0f172a; color: #fff; }
        [data-bs-theme="dark"] .dropdown-divider { border-color: #334155; }
        [data-bs-theme="dark"] .skeleton { background: linear-gradient(90deg, #1e293b 25%, #0f172a 50%, #1e293b 75%); background-size: 200% 100%; }
        [data-bs-theme="dark"] .status-pill.pill-expired { background: rgba(220,38,38,0.15); }
        [data-bs-theme="dark"] .status-pill.pill-expiring { background: rgba(245,158,11,0.15); }
        [data-bs-theme="dark"] .status-pill.pill-lowstock { background: rgba(225,29,72,0.15); }
        [data-bs-theme="dark"] .status-pill.pill-good { background: rgba(34,197,94,0.15); }
    </style>
    @stack('styles')
</head>
<body>
    @auth
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar glass-sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
            </div>
            <div class="brand-text">
                <span class="brand-name">PharmaAlert</span>
                <span class="brand-sub">Stock Management</span>
            </div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-section">Main Menu</div>

            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}" href="{{ route('medicines.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg> Inventory
                    @php $medCount = \App\Models\Medicine::count(); @endphp
                    @if ($medCount > 0)
                        <span class="nav-badge">{{ $medCount }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1"/><path d="M9 17h6"/><path d="M15 11H9"/><path d="M19 17h2V9"/><path d="M19 9h-4v8"/><path d="M5 17v1h2"/></svg> Suppliers
                    @php $supCount = \App\Models\Supplier::count(); @endphp
                    @if ($supCount > 0)
                        <span class="nav-badge">{{ $supCount }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-section">Monitoring</div>

            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('alerts.*') ? 'active' : '' }}" href="{{ route('alerts.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg> Stock Alerts
                    @php $alertCount = \App\Models\Alert::count(); @endphp
                    @if ($alertCount > 0)
                        <span class="nav-badge bg-danger" style="color:#fff;">{{ $alertCount }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-section">Reports</div>

            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="4" y="14" width="4" height="6"/><rect x="10" y="10" width="4" height="10"/><rect x="16" y="4" width="4" height="16"/></svg> Reports & Analytics
                </a>
            </div>

            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="3"/><path d="M12 1v2"/><path d="M12 21v2"/><path d="M4.22 4.22l1.42 1.42"/><path d="M18.36 18.36l1.42 1.42"/><path d="M1 12h2"/><path d="M21 12h2"/><path d="M4.22 19.78l1.42-1.42"/><path d="M18.36 5.64l1.42-1.42"/></svg> Settings
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg> Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="main-content">
        <header class="topbar glass-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn-icon d-lg-none" onclick="toggleSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div class="page-title">
                    @if(request()->routeIs('dashboard'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                            <path d="M12 2a10 10 0 1 0 10 10"/>
                            <path d="M12 12 9.5 9.5"/>
                            <path d="M12 7v5"/>
                            <path d="M12 2v4"/>
                            <circle cx="12" cy="12" r="1"/>
                        </svg>
                    @else
                        @yield('page-icon')
                    @endif
                    @yield('page-title', 'Dashboard')
                </div>
            </div>
            <div class="topbar-actions">
                <button class="btn-icon" onclick="toggleDarkMode()" title="Toggle dark mode">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="darkModeIcon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>
                <a href="{{ route('alerts.index') }}" class="btn-icon" title="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3Z"/><path d="M12 22a2 2 0 0 0 2-2h-4a2 2 0 0 0 2 2Z"/><path d="M8 5a4 4 0 0 1 8 0"/></svg>
                    @php $totalAlerts = \App\Models\Alert::count(); @endphp
                    @if ($totalAlerts > 0)
                        <span class="badge-dot"></span>
                    @endif
                </a>
                <div class="dropdown">
                    <a class="user-dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</div>
                        <span class="user-name">{{ Auth::user()->username }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="dropdown-arrow"><polyline points="6 9 12 15 18 9"/></svg>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius:12px;border:1px solid var(--border-color);min-width:200px;padding:0.5rem;">
                        <li><span class="dropdown-item-text" style="font-size:0.8rem;padding:0.5rem 1rem;"><small class="text-muted">Signed in as</small><br><strong>{{ Auth::user()->username }}</strong></span></li>
                        <li><hr class="dropdown-divider" style="margin:0.25rem 0;"></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('medicines.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>Inventory</a></li>
                        <li><a class="dropdown-item" href="{{ route('suppliers.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1"/><path d="M9 17h6"/><path d="M15 11H9"/><path d="M19 17h2V9"/><path d="M19 9h-4v8"/><path d="M5 17v1h2"/></svg>Suppliers</a></li>
                        <li><a class="dropdown-item" href="{{ route('alerts.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>Alerts</a></li>
                        <li><hr class="dropdown-divider" style="margin:0.25rem 0;"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" style="border-radius:8px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert" style="border-radius:12px;border:none;background:var(--success-light);color:var(--success);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert" style="border-radius:12px;border:none;background:var(--danger-light);color:var(--danger);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ session('error') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    @push('scripts')
    <script>
        // Sidebar toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        // Dark mode toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            const icon = document.getElementById('darkModeIcon');
            if (html.getAttribute('data-bs-theme') === 'dark') {
                html.setAttribute('data-bs-theme', 'light');
                icon.innerHTML = '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>';
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-bs-theme', 'dark');
                icon.innerHTML = '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Restore theme on load
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                const icon = document.getElementById('darkModeIcon');
                if (icon) icon.innerHTML = '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';
            }
        })();

        // SweetAlert confirmations
        document.querySelectorAll('[data-confirm]').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                const msg = this.getAttribute('data-confirm') || 'Are you sure?';
                const form = this.closest('form') || document.querySelector(this.getAttribute('data-target'));
                Swal.fire({
                    title: 'Confirm',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then(result => { if (result.isConfirmed && form) form.submit(); });
            });
        });
    </script>
    @endpush
    @endauth

    @guest
        @yield('content')
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
