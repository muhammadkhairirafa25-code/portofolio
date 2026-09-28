<?php
session_start();

// Proteksi Halaman: Jika belum login, tendang ke login.php (atau index.php)
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php"); // Ganti index.php/login.php sesuai nama file login Anda
    exit();
}

$driver_id = $_SESSION['driver_id'] ?? 'Driver 44';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Telemetry | F1 Petronas</title>
    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;0,700;0,900;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-color: #080c10;
            --card-bg: #101720;
            --card-hover: #16202c;
            --text-main: #f8fafc;
            --text-muted: #8ea1b5;
            --petronas-teal: #00d2be;
            --petronas-glow: rgba(0, 210, 190, 0.3);
            --border: #1e2d3d;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Titillium Web', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- 1. SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--card-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border);
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: rgba(0, 210, 190, 0.1);
            border: 2px solid var(--petronas-teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--petronas-teal);
            font-size: 1.2rem;
            box-shadow: 0 0 10px var(--petronas-glow);
        }

        .brand-title {
            font-size: 1.1rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.1;
        }

        .brand-title span {
            color: var(--petronas-teal);
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1.5rem 0.75rem;
            flex: 1;
        }

        .menu-item {
            margin-bottom: 0.5rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .menu-link:hover, .menu-link.active {
            background-color: var(--card-hover);
            color: var(--petronas-teal);
            border-left: 3px solid var(--petronas-teal);
        }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid var(--border);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 77, 77, 0.1);
            border: 1px solid rgba(255, 77, 77, 0.3);
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 77, 77, 0.25);
            color: #fff;
        }

        /* --- LAYOUT UTAMA (Header, Content, Footer) --- */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- 2. HEADER --- */
        .header {
            height: 70px;
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .header-title {
            font-size: 1.2rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-badge {
            background: rgba(0, 210, 190, 0.15);
            border: 1px solid var(--petronas-teal);
            color: var(--petronas-teal);
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 12px;
            font-style: normal;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid var(--petronas-teal);
            background: #1e2d3d;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 700;
            line-height: 1;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* --- 3. CONTENT AREA --- */
        .content {
            padding: 2rem;
            flex: 1;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .metric-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-3px);
            border-color: var(--petronas-teal);
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--petronas-teal);
        }

        .metric-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .metric-value {
            font-size: 1.8rem;
            font-weight: 900;
            font-style: italic;
            color: #fff;
        }

        .metric-unit {
            font-size: 0.9rem;
            color: var(--petronas-teal);
            font-style: normal;
        }

        /* Telemetry Section */
        .panel-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        .panel-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.5rem;
        }

        .panel-title {
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--amg-silver);
        }

        .panel-title i {
            color: var(--petronas-teal);
        }

        .placeholder-chart {
            height: 220px;
            border: 1px dashed var(--border);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-style: italic;
        }

        .event-list {
            list-style: none;
        }

        .event-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.85rem;
        }

        .event-item:last-child {
            border-bottom: none;
        }

        .event-time {
            color: var(--petronas-teal);
            font-weight: 700;
        }

        /* --- 4. FOOTER --- */
        .footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border);
            padding: 1rem 2rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-status {
            color: var(--petronas-teal);
            font-weight: 700;
        }

        /* Responsive Layout */
        @media (max-width: 992px) {
            .panel-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-brand .brand-title, .menu-link span, .logout-btn span { display: none; }
            .main-wrapper { margin-left: 70px; }
            .header { padding: 0 1rem; }
            .content { padding: 1rem; }
        }
    </style>
</head>
<body>

    <!-- 1. SIDEBAR -->
    <aside class="sidebar">
        <div>
            <div class="sidebar-brand">
                <div class="brand-logo">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <div class="brand-title">
                    Petronas
                    <span>Telemetry v2.4</span>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-item">
                    <a href="#" class="menu-link active">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fa-solid fa-stopwatch"></i>
                        <span>Lap Times</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fa-solid fa-car"></i>
                        <span>Car Setup</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fa-solid fa-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Exit Pit</span>
            </a>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">

        <!-- 2. HEADER -->
        <header class="header">
            <div class="header-title">
                Live Telemetry
                <span class="status-badge"><i class="fa-solid fa-circle"></i> PIT OPEN</span>
            </div>

            <div class="user-profile">
                <div class="user-info">
                    <div class="user-name"><?= htmlspecialchars($driver_id); ?></div>
                    <div class="user-role">Primary Driver</div>
                </div>
                <img src="https://api.dicebear.com/9.x/avataaars/svg?seed=Lewis&clothing=blazerAndShirt&clothingColor=black" alt="Avatar" class="user-avatar">
            </div>
        </header>

        <!-- 3. CONTENT AREA -->
        <main class="content">

            <!-- Stat Cards -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-header">
                        <span>Top Speed</span>
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div class="metric-value">334.2 <span class="metric-unit">KM/H</span></div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <span>Best Lap</span>
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <div class="metric-value">1:18.421</div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <span>Tyre Condition</span>
                        <i class="fa-solid fa-compact-disc"></i>
                    </div>
                    <div class="metric-value">84% <span class="metric-unit">(SOFT)</span></div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <span>Fuel Load</span>
                        <i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <div class="metric-value">32.4 <span class="metric-unit">KG</span></div>
                </div>
            </div>

            <!-- Panels Grid -->
            <div class="panel-grid">
                <div class="panel-card">
                    <div class="panel-title">
                        <i class="fa-solid fa-wave-square"></i> Speed & RPM Telemetry
                    </div>
                    <div class="placeholder-chart">
                        [ Area Grafik Telemetri Real-Time ]
                    </div>
                </div>

                <div class="panel-card">
                    <div class="panel-title">
                        <i class="fa-solid fa-flag-checkered"></i> Live Pit Radio / Events
                    </div>
                    <ul class="event-list">
                        <li class="event-item">
                            <span>Box, Box for Hard tyres</span>
                            <span class="event-time">L24</span>
                        </li>
                        <li class="event-item">
                            <span>Fastest Sector 2 recorded</span>
                            <span class="event-time">L21</span>
                        </li>
                        <li class="event-item">
                            <span>Track Limit warning at Turn 9</span>
                            <span class="event-time">L15</span>
                        </li>
                        <li class="event-item">
                            <span>DRS Enabled</span>
                            <span class="event-time">L03</span>
                        </li>
                    </ul>
                </div>
            </div>

        </main>

        <!-- 4. FOOTER -->
        <footer class="footer">
            <div>
                &copy; <?= date('Y'); ?> Mercedes-AMG PETRONAS Formula One Team.
            </div>
            <div>
                System Status: <span class="footer-status">ONLINE /// 12ms Latency</span>
            </div>
        </footer>

    </div>

</body>
</html>