<?php
session_start();

// 1. Cek jika driver sudah login, langsung lempar ke dashboard
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error_message = "";

// 2. Proses saat form disubmit via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Contoh validasi sederhana (Ganti dengan pengecekan database jika sudah pakai MySQL)
    if ($username === "rafachalamet" && $password === "petronas123") {
        // Buat session
        $_SESSION['is_logged_in'] = true;
        $_SESSION['driver_id'] = $username;

        // Redirect ke halaman lain
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Akses ditolak! Driver ID atau Password tidak valid.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Access | F1 Petronas Login</title>
    <!-- Import Google Font Khas F1 Telemetry -->
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;0,700;0,900;1,700&display=swap" rel="stylesheet">
    <!-- Import FontAwesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS Variables - Mercedes F1 Petronas Tosca Theme */
        :root {
            --bg-color: #080c10;
            --card-bg: #101720;
            --card-bg-hover: #16202c;
            --text-main: #f8fafc;
            --text-muted: #8ea1b5;
            --petronas-teal: #00d2be;
            --petronas-glow: rgba(0, 210, 190, 0.4);
            --amg-silver: #e2e8f0;
            --border: #1e2d3d;
            --carbon-line: rgba(255, 255, 255, 0.03);
            --error-red: #ff4d4d;
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem 1rem;
            background-image: 
                radial-gradient(circle at 85% 15%, var(--petronas-glow) 0%, transparent 40%),
                radial-gradient(circle at 15% 85%, rgba(0, 210, 190, 0.1) 0%, transparent 45%),
                linear-gradient(var(--carbon-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--carbon-line) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 20px 20px, 20px 20px;
        }

        .login-card {
            max-width: 440px;
            width: 100%;
            background-color: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border);
            border-top: 4px solid var(--petronas-teal);
            padding: 2.5rem 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.8), 0 0 25px rgba(0, 210, 190, 0.15);
            position: relative;
        }

        .login-card::before {
            content: '/// PIT ACCESS v2.4';
            position: absolute;
            top: 12px;
            right: 20px;
            font-size: 0.65rem;
            font-weight: 900;
            font-style: italic;
            color: rgba(255, 255, 255, 0.15);
            letter-spacing: 2px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            background: rgba(0, 210, 190, 0.1);
            border: 2px solid var(--petronas-teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--petronas-teal);
            font-size: 1.5rem;
            box-shadow: 0 0 15px var(--petronas-glow);
        }

        .login-title {
            font-size: 1.6rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fff;
        }

        .login-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Styling Alert Pesan Error PHP */
        .alert-error {
            background: rgba(255, 77, 77, 0.12);
            border: 1px solid var(--error-red);
            color: #ff8080;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--amg-silver);
            margin-bottom: 0.4rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 1rem;
            transition: color 0.3s;
        }

        .form-input {
            width: 100%;
            background-color: rgba(8, 12, 16, 0.7);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.75rem 1rem 0.75rem 2.6rem;
            color: #fff;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: var(--petronas-teal);
            box-shadow: 0 0 12px var(--petronas-glow);
            background-color: rgba(16, 23, 32, 0.9);
        }

        .form-input:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--petronas-teal);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: var(--petronas-teal);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            margin-bottom: 1.75rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }

        .remember-me input {
            accent-color: var(--petronas-teal);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--petronas-teal);
            text-decoration: none;
            font-weight: 700;
            transition: opacity 0.3s;
        }

        .forgot-link:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background: var(--petronas-teal);
            color: #000;
            padding: 0.85rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: none;
            border-radius: 4px;
            transform: skewX(-12deg);
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 0 15px var(--petronas-glow);
            font-size: 1rem;
        }

        .btn-submit:hover {
            background-color: #00f5d4;
            transform: skewX(-12deg) translateY(-2px);
            box-shadow: 0 0 25px rgba(0, 245, 212, 0.6);
        }

        .btn-submit span {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transform: skewX(12deg);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.75rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border);
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .login-footer a {
            color: var(--petronas-teal);
            text-decoration: none;
            font-weight: 700;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .f1-mascot {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }

        @keyframes floatMascot {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .mascot-avatar {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            border: 3px solid var(--petronas-teal);
            box-shadow: 0 0 15px var(--petronas-glow);
            background-color: var(--card-bg);
            object-fit: cover;
            animation: floatMascot 3s ease-in-out infinite;
            transition: transform 0.3s ease;
        }

        .f1-mascot:hover .mascot-avatar {
            transform: scale(1.1);
            animation-play-state: paused;
        }

        .mascot-tooltip {
            background-color: var(--card-bg);
            color: var(--text-main);
            padding: 5px 12px;
            border-radius: 16px;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid var(--petronas-teal);
            margin-bottom: 8px;
            opacity: 0;
            transform: translateY(8px);
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            pointer-events: none;
            white-space: nowrap;
        }

        .f1-mascot:hover .mascot-tooltip {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .login-card { padding: 2rem 1.25rem; }
            .login-card::before { display: none; }
            .f1-mascot { bottom: 15px; right: 15px; }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="brand-icon">
                <i class="fa-solid fa-gauge-high"></i>
            </div>
            <h1 class="login-title">Driver Access</h1>
            <p class="login-subtitle">Masukkan Telemetri Akun</p>
        </div>

        <!-- Notifikasi Error PHP -->
        <?php if (!empty($error_message)): ?>
            <div class="alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?= htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <!-- Form Login PHP -->
        <form action="login.php" method="POST">
            <div class="form-group">
                <label class="form-label">Username / Driver ID</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user-astronaut input-icon"></i>
                    <input type="text" name="username" class="form-input" placeholder="rafachalamet" required autocomplete="username">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required autocomplete="current-password">
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Tetap Login</span>
                </label>
                <a href="#" class="forgot-link" onclick="alert('Instruksi reset password dikirim ke email Pit Team.')">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-submit">
                <span><i class="fa-solid fa-flag-checkered"></i> Masuk Ke Pit Lane</span>
            </button>
        </form>

        <div class="login-footer">
            Belum punya lisensi driver? <a href="#" onclick="alert('Form pendaftaran driver belum dibuka.')">Daftar Akun</a>
        </div>
    </div>

    <div class="f1-mascot" onclick="alert('Uji kredensial: Username: rafachalamet | Password: petronas123')">
        <div class="mascot-tooltip">Klik untuk cek Akun Testing! 🏎️</div>
        <img src="https://api.dicebear.com/9.x/avataaars/svg?seed=Lewis&clothing=blazerAndShirt&clothingColor=black&mouth=smile" alt="Mini Mascot" class="mascot-avatar">
    </div>

    <script>
    function togglePasswordVisibility() {
        const passInput = document.getElementById('password');
        const icon = document.querySelector('.toggle-password');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html>