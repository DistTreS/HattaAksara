<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ruang Hatta Muda') | Hatta Muda Connection</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Merriweather:ital,wght@0,400;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --maroon-deep: #5e1116;
            --maroon-primary: #7a161e;
            --gold-primary: #c59b27;
            --gold-light: #e6b94d;
            --slate-900: #0d131f;
            --slate-800: #172033;
            --slate-100: #f1f5f9;
            --bg-parchment: #f8fafc;
            --border-color: #e2e8f0;
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
            background-color: var(--bg-parchment);
            color: #1e293b;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 270px;
            background: var(--slate-900);
            color: #cbd5e1;
            display: flex;
            flex-direction: column;
            border-right: 2px solid rgba(197, 155, 39, 0.25);
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-emblem {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--maroon-primary), var(--maroon-deep));
            border: 1.5px solid var(--gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-light);
            font-weight: 700;
            font-family: var(--font-display);
        }
        .sidebar-title h2 {
            font-size: 0.95rem;
            font-weight: 700;
            color: white;
            font-family: var(--font-display);
            letter-spacing: 0.05em;
        }
        .sidebar-title span {
            font-size: 0.72rem;
            color: var(--gold-light);
            display: block;
        }

        .sidebar-nav {
            list-style: none;
            padding: 20px 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .nav-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            font-weight: 700;
            padding: 12px 10px 4px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            color: #94a3b8;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(122, 22, 30, 0.35);
            color: #ffffff;
            border-left: 3px solid var(--gold-primary);
        }
        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-user {
            padding: 18px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .sidebar-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--maroon-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* Main Workspace */
        .workspace {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .workspace-topbar {
            height: 68px;
            background: white;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }
        .workspace-content {
            padding: 32px;
            flex: 1;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        /* Buttons & Forms */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-primary {
            background: var(--maroon-primary);
            color: white;
        }
        .btn-primary:hover {
            background: var(--maroon-deep);
        }
        .btn-outline {
            border: 1px solid var(--border-color);
            background: white;
            color: #334155;
        }
        .btn-outline:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

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

        /* Mobile Alumni Responsiveness */
        .alumni-mobile-toggle {
            display: none;
            background: none;
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            border-radius: 6px;
            color: #334155;
            cursor: pointer;
            font-size: 1.1rem;
        }
        .alumni-sidebar-close {
            display: none;
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.4rem;
            cursor: pointer;
            padding: 4px 8px;
        }
        .alumni-sidebar-close:hover {
            color: white;
        }
        .alumni-overlay {
            position: fixed;
            inset: 0;
            background: rgba(13, 19, 31, 0.65);
            backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .alumni-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 991px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                box-shadow: 10px 0 30px rgba(0,0,0,0.3);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .alumni-mobile-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .alumni-sidebar-close {
                display: block;
            }
            .workspace-topbar {
                padding: 0 16px;
            }
            .workspace-content {
                padding: 20px 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="alumni-overlay" id="alumniOverlay" onclick="closeAlumniSidebar()"></div>

    <aside class="sidebar" id="alumniSidebar">
        <div class="sidebar-header" style="justify-content: space-between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div class="sidebar-emblem">HM</div>
                <div class="sidebar-title">
                    <h2>HATTA MUDA</h2>
                    <span>Alumni Connection</span>
                </div>
            </div>
            <button class="alumni-sidebar-close" onclick="closeAlumniSidebar()" aria-label="Tutup">&times;</button>
        </div>

        <ul class="sidebar-nav">
            <li class="nav-label">Menu Utama</li>
            <li>
                <a href="{{ route('alumni.dashboard') }}" class="sidebar-link {{ request()->routeIs('alumni.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('alumni.my-posts') }}" class="sidebar-link {{ request()->routeIs('alumni.my-posts') ? 'active' : '' }}">
                    <i class="fa-solid fa-feather"></i> Tulisan Saya
                </a>
            </li>

            <li class="nav-label">Ruang Tulis</li>
            <li>
                <a href="{{ route('alumni.create-aksi') }}" class="sidebar-link {{ request()->routeIs('alumni.create-aksi') ? 'active' : '' }}">
                    <i class="fa-solid fa-hands-holding-circle"></i> Tulis Aksi Hatta Muda
                </a>
            </li>
            <li>
                <a href="{{ route('alumni.create-artikel') }}" class="sidebar-link {{ request()->routeIs('alumni.create-artikel') ? 'active' : '' }}">
                    <i class="fa-solid fa-lightbulb"></i> Tulis Artikel Gagasan
                </a>
            </li>

            <li class="nav-label">Jejaring & Profil</li>
            <li>
                <a href="{{ route('alumni.networking') }}" class="sidebar-link {{ request()->routeIs('alumni.networking') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-viewfinder"></i> Direktori Jejaring
                </a>
            </li>
            <li>
                <a href="{{ route('alumni.profile') }}" class="sidebar-link {{ request()->routeIs('alumni.profile') ? 'active' : '' }}">
                    <i class="fa-solid fa-id-card"></i> Profil Personal
                </a>
            </li>

            <li class="nav-label">Navigasi Luar</li>
            <li>
                <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Portal Publik
                </a>
            </li>
        </ul>

        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div>
                    <div style="font-weight: 700; font-size: 0.82rem; color:white;">{{ Str::limit(auth()->user()->name, 16) }}</div>
                    <div style="font-size: 0.72rem; color:var(--gold-light);">{{ auth()->user()->alumniProfile?->islt_batch ?? 'Alumni ISLT' }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer;" title="Keluar">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <div class="workspace">
        <header class="workspace-topbar">
            <div style="display: flex; align-items: center; gap: 12px;">
                <button class="alumni-mobile-toggle" onclick="openAlumniSidebar()" aria-label="Buka Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h1 style="font-size: 1.15rem; font-weight: 700; color:#0f172a;">@yield('page_title', 'Ruang Hatta Muda Connection')</h1>
                    <span style="font-size: 0.8rem; color:#64748b;">Hatta Aksara Project - Ekosistem Alumni Berkelanjutan</span>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('alumni.create-aksi') }}" class="btn btn-primary" style="font-size: 0.82rem;">
                    <i class="fa-solid fa-plus"></i> <span style="display:inline-block;">Buat Tulisan Baru</span>
                </a>
            </div>
        </header>

        <main class="workspace-content">
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
        function openAlumniSidebar() {
            document.getElementById('alumniSidebar').classList.add('active');
            document.getElementById('alumniOverlay').classList.add('active');
        }
        function closeAlumniSidebar() {
            document.getElementById('alumniSidebar').classList.remove('active');
            document.getElementById('alumniOverlay').classList.remove('active');
        }
    </script>
    @stack('scripts')
</body>
</html>
