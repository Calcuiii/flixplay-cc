<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - FlixPlay</title>
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
        }
        /* ============ NAVBAR ============ */
        nav {
            background: linear-gradient(to right, rgba(10, 14, 39, 0.95), rgba(26, 26, 62, 0.95));
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 2px solid #e94b3c;
            backdrop-filter: blur(10px);
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            background: linear-gradient(135deg, #e94b3c, #00d4d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
            align-items: center;
        }
        .nav-links a {
            color: #e5e5e5;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s;
            position: relative;
        }
        .nav-links a:hover {
            color: #e94b3c;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #e94b3c, #00d4d4);
            transition: width 0.3s;
        }
        .nav-links a:hover::after {
            width: 100%;
        }
        .nav-profile {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .search-box {
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #e94b3c;
            background-color: rgba(233, 75, 60, 0.1);
            color: #e5e5e5;
            width: 150px;
            transition: all 0.3s;
        }
        .search-box:focus {
            outline: none;
            background-color: rgba(233, 75, 60, 0.2);
            box-shadow: 0 0 10px rgba(233, 75, 60, 0.3);
        }
        .search-box::placeholder {
            color: #888;
        }
        .profile-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #e94b3c, #00d4d4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }
        .profile-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(233, 75, 60, 0.5);
        }
        /* ============ HERO SECTION ============ */
        .hero {
            height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 50px;
            color: white;
            margin-top: 70px;
            position: relative;
            border-bottom: 3px solid #e94b3c;
        }
        .hero video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: linear-gradient(rgba(10, 14, 39, 0.6), rgba(26, 26, 62, 0.8));
            z-index: 2;
            pointer-events: none;
        }
        .hero-content {
            position: relative;
            z-index: 3;
        }
        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #e94b3c, #00d4d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-content p {
            font-size: 18px;
            margin-bottom: 20px;
            max-width: 600px;
            line-height: 1.6;
            color: #b0b0b0;
        }
        .hero-buttons {
            display: flex;
            gap: 15px;
        }
        .btn-watch, .btn-info {
            padding: 12px 30px;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-watch {
            background: linear-gradient(135deg, #e94b3c, #d63a2a);
            color: #fff;
            box-shadow: 0 0 20px rgba(233, 75, 60, 0.4);
        }
        .btn-watch:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 25px rgba(233, 75, 60, 0.6);
        }
        .btn-info {
            background-color: rgba(0, 212, 212, 0.2);
            color: #00d4d4;
            border: 2px solid #00d4d4;
        }
        .btn-info:hover {
            background-color: rgba(0, 212, 212, 0.3);
            box-shadow: 0 0 15px rgba(0, 212, 212, 0.4);
        }
        /* ============ CATEGORY SECTION ============ */
        .category-section {
            padding: 50px;
        }
        .category-title {
            font-size: 24px;
            background: linear-gradient(90deg, #e94b3c, #00d4d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .movie-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }
        .movie-card {
            background: linear-gradient(135deg, #1a1a3e, #0f1a2e);
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            height: 300px;
            border: 1px solid rgba(233, 75, 60, 0.2);
        }
        .movie-card:hover {
            transform: scale(1.05) translateY(-10px);
            box-shadow: 0 15px 40px rgba(233, 75, 60, 0.3), 0 0 20px rgba(0, 212, 212, 0.2);
            border-color: rgba(233, 75, 60, 0.6);
        }
        .movie-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s;
        }
        .movie-card:hover img {
            opacity: 0.7;
        }
        .movie-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(10, 14, 39, 0.95), transparent);
            padding: 15px;
            transform: translateY(100%);
            transition: transform 0.3s;
        }
        .movie-card:hover .movie-overlay {
            transform: translateY(0);
        }
        .movie-title {
            background: linear-gradient(90deg, #e94b3c, #00d4d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .movie-rating {
            color: #e5e5e5;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .movie-actions {
            display: flex;
            gap: 10px;
        }
        .icon-btn {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #e94b3c, #00d4d4);
            border: none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s;
            box-shadow: 0 0 10px rgba(233, 75, 60, 0.3);
        }
        .icon-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 0 15px rgba(233, 75, 60, 0.6);
        }
        /* ============ FEATURED SECTION ============ */
        .featured-section {
            padding: 50px;
            background: linear-gradient(135deg, rgba(233, 75, 60, 0.05) 0%, rgba(0, 212, 212, 0.05) 100%);
            border-left: 5px solid #e94b3c;
            margin: 50px;
            border-radius: 15px;
            border: 1px solid rgba(233, 75, 60, 0.2);
        }
        .featured-title {
            font-size: 32px;
            background: linear-gradient(135deg, #e94b3c, #00d4d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .featured-desc {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.6;
            max-width: 700px;
            color: #b0b0b0;
        }
        .featured-img {
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            margin-top: 20px;
            border: 2px solid #e94b3c;
            box-shadow: 0 0 20px rgba(233, 75, 60, 0.3);
            transition: all 0.3s;
        }
        .featured-img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(233, 75, 60, 0.5);
        }
        /* ============ FOOTER ============ */
        footer {
            background: linear-gradient(to right, rgba(10, 14, 39, 0.9), rgba(26, 26, 62, 0.9));
            padding: 50px;
            border-top: 2px solid #e94b3c;
            text-align: center;
            color: #888;
            font-size: 14px;
        }
        footer p {
            margin: 10px 0;
        }
        .footer-links {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .footer-links a {
            background: linear-gradient(90deg, #e94b3c, #00d4d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            transition: all 0.3s;
        }
        .footer-links a:hover {
            filter: brightness(1.2);
        }
        @media (max-width: 768px) {
            nav {
                padding: 15px 20px;
                flex-wrap: wrap;
            }
            .nav-links {
                gap: 15px;
                font-size: 12px;
            }
            .hero {
                height: 400px;
                padding: 30px;
            }
            .hero-content h1 {
                font-size: 32px;
            }
            .category-section, .featured-section {
                padding: 30px 20px;
            }
            .movie-container {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- ============ NAVBAR ============ -->
    <nav>
        <a href="{{ route('home') }}" class="logo">▶ FlixPlay</a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('films.index') }}">Films</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
        <div class="nav-profile">
            <form action="{{ route('films.search') }}" method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="q" class="search-box" placeholder="Cari konten..." required>
            </form>
            @auth
                <div style="display: flex; gap: 15px; align-items: center;">
                    <a href="{{ route('dashboard') }}" style="color: #e5e5e5; text-decoration: none; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.color='#e94b3c'" onmouseout="this.style.color='#e5e5e5'">Dashboard</a>
                    
                    <!-- WATCHLIST LINK - LEBIH MENCOLOK -->
                    <a href="{{ route('watchlist.index') }}" style="color: #e5e5e5; text-decoration: none; font-size: 14px; font-weight: bold; transition: all 0.3s; padding: 8px 15px; background: rgba(233, 75, 60, 0.2); border-radius: 15px;" onmouseover="this.style.background='rgba(233, 75, 60, 0.3)'" onmouseout="this.style.background='rgba(233, 75, 60, 0.2)'">
                        📋 Watchlist
                    </a>
                    
                    <a href="{{ route('watch-history.index') }}" style="color: #e5e5e5; text-decoration: none; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.color='#e94b3c'" onmouseout="this.style.color='#e5e5e5'">Riwayat</a>
                                
                    <!-- ADMIN LINK -->
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" style="color: #e5e5e5; text-decoration: none; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.color='#e94b3c'" onmouseout="this.style.color='#e5e5e5'">⚙️ Admin</a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; border: none; padding: 8px 16px; border-radius: 20px; cursor: pointer; font-weight: bold; font-size: 12px;">Logout</button>
                    </form>
                </div>
            @else
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('login') }}" style="padding: 10px 20px; background: linear-gradient(135deg, #00d4d4, #00a8a8); color: white; text-decoration: none; border-radius: 20px; font-weight: bold; font-size: 13px; display: inline-block;">Login</a>
                    <a href="{{ route('register') }}" style="padding: 10px 20px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 20px; font-weight: bold; font-size: 13px; display: inline-block;">Register</a>
                </div>
            @endauth
        </div>
    </nav>
    <!-- ============ MAIN CONTENT ============ -->
    <main>
        @yield('content')
    </main>
    <!-- ============ FOOTER ============ -->
    <footer>
        <p>&copy; 2024 FlixPlay. All rights reserved.</p>
        <p>Platform streaming premium untuk hiburan Anda</p>
        <div class="footer-links">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('films.index') }}">Film</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="#privacy">Privasi</a>
        </div>
    </footer>
</body>
</html>