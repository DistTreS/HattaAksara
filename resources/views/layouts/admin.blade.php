<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Backoffice') | Hatta Aksara Project</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --maroon-deep: #5e1116;
            --maroon-primary: #7a161e;
            --gold-primary: #c59b27;
            --gold-light: #e6b94d;
            --slate-900: #0a0f1d;
            --slate-850: #0f172a;
            --slate-800: #1e293b;
            --border-dark: rgba(255,255,255,0.08);
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --font-display: 'Cinzel', serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background-color: #f1f5f9;
            color: #0f172a;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: var(--slate-900);
            color: #94a3b8;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #1e293b;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .admin-sidebar-header {
            padding: 22px 20px;
            border-bottom: 1px solid var(--border-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .admin-emblem {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: var(--maroon-primary);
            border: 1.5px solid var(--gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-light);
            font-family: var(--font-display);
            font-weight: 700;
        }
        .admin-brand h2 {
            color: white;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            font-family: var(--font-display);
        }
        .admin-brand span {
            font-size: 0.72rem;
            color: var(--gold-light);
            display: block;
        }

        .admin-nav {
            list-style: none;
            padding: 16px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .admin-nav-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            font-weight: 700;
            padding: 14px 10px 4px;
        }
        .admin-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            border-radius: 6px;
            color: #94a3b8;
            font-size: 0.86rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .admin-nav-link:hover, .admin-nav-link.active {
            background: rgba(122, 22, 30, 0.4);
            color: white;
            border-left: 3px solid var(--gold-primary);
        }
        .admin-nav-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .admin-nav-left i {
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
        }
        .badge {
            font-size: 0.72rem;
            padding: 2px 7px;
            border-radius: 12px;
            font-weight: 700;
        }
        .badge-warning {
            background: #f59e0b;
            color: #111827;
        }
        .badge-danger {
            background: #ef4444;
            color: white;
        }

        .admin-sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--border-dark);
            background: rgba(0,0,0,0.25);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Workspace */
        .admin-workspace {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .admin-topbar {
            height: 64px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }
        .admin-content {
            padding: 32px;
            flex: 1;
            max-width: 1380px;
            width: 100%;
            margin: 0 auto;
        }

        /* Components */
        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
            overflow: hidden;
            margin-bottom: 24px;
        }
        .card-header {
            padding: 16px 22px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }
        .card-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
        }
        .card-body {
            padding: 22px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
            text-align: left;
        }
        .table th {
            background: #f8fafc;
            padding: 12px 16px;
            font-weight: 700;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        .table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        .table tr:hover td {
            background: #fafcff;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-weight: 600;
            font-size: 0.84rem;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.78rem;
        }
        .btn-primary { background: var(--maroon-primary); color: white; }
        .btn-primary:hover { background: var(--maroon-deep); }
        .btn-success { background: #10b981; color: white; }
        .btn-success:hover { background: #059669; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-warning { background: #f59e0b; color: #111827; }
        .btn-gold { background: var(--gold-primary); color: #111827; font-weight: 700; }
        .btn-outline { border: 1px solid #cbd5e1; background: white; color: #334155; }
        .btn-outline:hover { background: #f8fafc; }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .alert-success { background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error { background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }
        .alert-warning { background: #fffbeb; color: #92400e; border-left: 4px solid #f59e0b; }
        .alert-info { background: #eff6ff; color: #1e40af; border-left: 4px solid #3b82f6; }

        /* Admin Mobile Responsiveness */
        .admin-mobile-toggle {
            display: none;
            background: none;
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            border-radius: 6px;
            color: #334155;
            cursor: pointer;
            font-size: 1.1rem;
        }
        .admin-sidebar-close {
            display: none;
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.4rem;
            cursor: pointer;
            padding: 4px 8px;
        }
        .admin-sidebar-close:hover {
            color: white;
        }
        .admin-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 15, 29, 0.65);
            backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .admin-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 991px) {
            .admin-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                box-shadow: 10px 0 30px rgba(0,0,0,0.3);
            }
            .admin-sidebar.active {
                transform: translateX(0);
            }
            .admin-mobile-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .admin-sidebar-close {
                display: block;
            }
            .admin-topbar {
                padding: 0 16px;
            }
            .admin-content {
                padding: 20px 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="admin-overlay" id="adminOverlay" onclick="closeAdminSidebar()"></div>

    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-header" style="justify-content: space-between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div class="admin-emblem">HA</div>
                <div class="admin-brand">
                    <h2>HATTA AKSARA</h2>
                    <span>Redaksi & Manajemen</span>
                </div>
            </div>
            <button class="admin-sidebar-close" onclick="closeAdminSidebar()" aria-label="Tutup">&times;</button>
        </div>

        <ul class="admin-nav">
            <li class="admin-nav-label">Ikhtisar</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-chart-line"></i> Dashboard</span>
                </a>
            </li>

            <li class="admin-nav-label">Verifikasi & Kurasi</li>
            <li>
                <a href="{{ route('admin.verify-alumni.index') }}" class="admin-nav-link {{ request()->routeIs('admin.verify-alumni.*') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-user-check"></i> Verifikasi Hatta Muda</span>
                    @php
                        $pendingAlumniNav = \App\Models\User::where('role', 'hatta_muda')->where('status', 'pending')->count();
                    @endphp
                    @if($pendingAlumniNav > 0)
                        <span class="badge badge-warning">{{ $pendingAlumniNav }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.review-posts.index') }}" class="admin-nav-link {{ request()->routeIs('admin.review-posts.*') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-newspaper"></i> Moderasi Tulisan</span>
                    @php
                        $pendingPostsNav = \App\Models\Post::where('status', 'pending_review')->count();
                    @endphp
                    @if($pendingPostsNav > 0)
                        <span class="badge badge-danger">{{ $pendingPostsNav }}</span>
                    @endif
                </a>
            </li>

            <li class="admin-nav-label">Program & Seleksi</li>
            <li>
                <a href="{{ route('admin.islt.index') }}" class="admin-nav-link {{ request()->routeIs('admin.islt.*') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-id-card-clip"></i> Pendaftar ISLT</span>
                    @php
                        $totalApplicantsNav = \App\Models\IsltApplicant::count();
                    @endphp
                    <span class="badge" style="background:#334155; color:white;">{{ $totalApplicantsNav }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.programs.index') }}" class="admin-nav-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-layer-group"></i> Kelola Program</span>
                </a>
            </li>

            <li class="admin-nav-label">Publikasi & Dokumen</li>
            <li>
                <a href="{{ route('admin.posts.index') }}" class="admin-nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-bullhorn"></i> Berita & Kegiatan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-tags"></i> Kategori & Sub</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.ejournal.index') }}" class="admin-nav-link {{ request()->routeIs('admin.ejournal.*') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-book-bookmark"></i> E-Jurnal Digital</span>
                </a>
            </li>

            <li class="admin-nav-label">Profil Organisasi</li>
            <li>
                <a href="{{ route('admin.about.index') }}" class="admin-nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                    <span class="admin-nav-left"><i class="fa-solid fa-landmark"></i> Kelola Halaman Tentang</span>
                </a>
            </li>
        </ul>

        <div class="admin-sidebar-footer">
            <div style="font-size:0.8rem; color:white; font-weight:600;">
                <i class="fa-solid fa-user-shield" style="color:var(--gold-light); margin-right:6px;"></i> Admin Redaksi
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer;" title="Keluar">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-workspace">
        <header class="admin-topbar">
            <div style="display: flex; align-items: center; gap: 12px;">
                <button class="admin-mobile-toggle" onclick="openAdminSidebar()" aria-label="Buka Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h1 style="font-size: 1.1rem; font-weight: 700; color:#0f172a;">@yield('page_title', 'Admin Redaksi Hatta Aksara')</h1>
                    <span style="font-size: 0.78rem; color:#64748b;">Hatta Aksara Project - Panel Pengelolaan Terpadu</span>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <a href="{{ route('home') }}" class="btn btn-outline btn-sm" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Web Publik
                </a>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i> <span style="display:inline-block;">Tulis Berita</span>
                </a>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <span><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <span><i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    <span><i class="fa-solid fa-circle-exclamation"></i> {{ session('warning') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    <span><i class="fa-solid fa-circle-info"></i> {{ session('info') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function openAdminSidebar() {
            document.getElementById('adminSidebar').classList.add('active');
            document.getElementById('adminOverlay').classList.add('active');
        }
        function closeAdminSidebar() {
            document.getElementById('adminSidebar').classList.remove('active');
            document.getElementById('adminOverlay').classList.remove('active');
        }
    </script>
    @stack('scripts')
</body>
</html>
