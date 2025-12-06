<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin FlixPlay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a0e27 0%, #1a1a3e 50%, #0a0e27 100%);
            color: #e5e5e5;
            min-height: 100vh;
            display: flex;
        }
        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: linear-gradient(to right, rgba(10, 14, 39, 0.95), rgba(26, 26, 62, 0.95));
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            border-right: 2px solid #e94b3c;
        }
        .sidebar-logo {
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(135deg, #e94b3c, #00d4d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 30px;
        }
        .sidebar-menu {
            list-style: none;
        }
        .sidebar-menu li {
            margin-bottom: 15px;
        }
        .sidebar-menu a {
            color: #b0b0b0;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: linear-gradient(135deg, rgba(233, 75, 60, 0.2), rgba(0, 212, 212, 0.2));
            color: #00d4d4;
        }
        /* MAIN CONTENT */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(233, 75, 60, 0.2);
        }
        .header h1 {
            background: linear-gradient(135deg, #e94b3c, #00d4d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .header-actions {
            display: flex;
            gap: 15px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #e94b3c, #d63a2a);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(233, 75, 60, 0.4);
        }
        .btn-secondary {
            background: rgba(0, 212, 212, 0.2);
            color: #00d4d4;
            border: 1px solid #00d4d4;
        }
        .btn-secondary:hover {
            background: rgba(0, 212, 212, 0.3);
        }
        .btn-danger {
            background: rgba(233, 75, 60, 0.3);
            color: #e94b3c;
            border: 1px solid #e94b3c;
        }
        .btn-danger:hover {
            background: rgba(233, 75, 60, 0.5);
        }
        /* ALERT */
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: rgba(0, 212, 212, 0.2);
            border-left: 4px solid #00d4d4;
            color: #00d4d4;
        }
        .alert-error {
            background: rgba(233, 75, 60, 0.2);
            border-left: 4px solid #e94b3c;
            color: #e94b3c;
        }
        /* TABLE */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: linear-gradient(135deg, #1a1a3e, #0f1a2e);
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background: linear-gradient(135deg, rgba(233, 75, 60, 0.2), rgba(0, 212, 212, 0.2));
            padding: 15px;
            text-align: left;
            color: #00d4d4;
            font-weight: bold;
        }
        .table td {
            padding: 15px;
            border-bottom: 1px solid rgba(233, 75, 60, 0.1);
        }
        .table tr:hover {
            background: rgba(233, 75, 60, 0.05);
        }
        /* FORM */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #e5e5e5;
            font-weight: bold;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            background: rgba(0, 212, 212, 0.1);
            border: 1px solid #00d4d4;
            border-radius: 6px;
            color: #e5e5e5;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            background: rgba(0, 212, 212, 0.2);
            box-shadow: 0 0 10px rgba(0, 212, 212, 0.3);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-logo">⚙️ Admin</div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-graph-up"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.films.index') }}" class="{{ request()->routeIs('admin.films.*') ? 'active' : '' }}">
                    <i class="bi bi-film"></i> Film
                </a>
            </li>
            <li>
                <a href="{{ route('admin.genres.index') }}" class="{{ request()->routeIs('admin.genres.*') ? 'active' : '' }}">
                    <i class="bi bi-tag"></i> Genre
                </a>
            </li>
            <li style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(233, 75, 60, 0.2);">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="width: 100%; background: none; border: none; color: #e94b3c; text-align: left; padding: 12px 15px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.3s;" onmouseover="this.style.background='rgba(233, 75, 60, 0.2)'" onmouseout="this.style.background='none'">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        @if (session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <div class="header">
            <h1>@yield('page-title')</h1>
            <div class="header-actions">
                @yield('header-actions')
            </div>
        </div>

        @yield('content')
    </div>
</body>
</html>