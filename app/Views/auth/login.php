<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Data Dosen TRPL</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
            position: relative;
            background: linear-gradient(135deg, #07152e, #102f66, #164e9b, #0c234b);
            background-size: 300% 300%;
            animation: backgroundMove 12s ease infinite;
        }

        @keyframes backgroundMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Dekorasi cahaya background */
        .glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(3px);
            pointer-events: none;
            z-index: 0;
            animation: floatGlow 9s ease-in-out infinite alternate;
        }

        .glow-one {
            width: 350px;
            height: 350px;
            background: rgba(59, 130, 246, .28);
            top: -100px;
            left: -90px;
        }

        .glow-two {
            width: 400px;
            height: 400px;
            background: rgba(14, 165, 233, .20);
            right: -120px;
            bottom: -130px;
            animation-delay: 2s;
        }

        .glow-three {
            width: 180px;
            height: 180px;
            background: rgba(96, 165, 250, .18);
            top: 45%;
            left: 12%;
            animation-delay: 4s;
        }

        @keyframes floatGlow {
            from {
                transform: translate(0, 0) scale(1);
            }
            to {
                transform: translate(35px, -30px) scale(1.15);
            }
        }

        /* Lingkaran dekoratif */
        .circle {
            position: fixed;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 50%;
            pointer-events: none;
            animation: rotateCircle 25s linear infinite;
        }

        .circle-one {
            width: 450px;
            height: 450px;
            top: -170px;
            right: -100px;
        }

        .circle-two {
            width: 280px;
            height: 280px;
            bottom: -100px;
            left: -80px;
            animation-direction: reverse;
        }

        @keyframes rotateCircle {
            to { transform: rotate(360deg); }
        }

        /* Partikel */
        .particles {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(255,255,255,.8);
            box-shadow: 0 0 12px rgba(147,197,253,.9);
            animation: particleFloat linear infinite;
        }

        .particle:nth-child(1) { left: 10%; top: 80%; animation-duration: 12s; }
        .particle:nth-child(2) { left: 20%; top: 30%; animation-duration: 16s; }
        .particle:nth-child(3) { left: 35%; top: 90%; animation-duration: 13s; }
        .particle:nth-child(4) { left: 50%; top: 70%; animation-duration: 18s; }
        .particle:nth-child(5) { left: 65%; top: 20%; animation-duration: 14s; }
        .particle:nth-child(6) { left: 80%; top: 85%; animation-duration: 17s; }
        .particle:nth-child(7) { left: 90%; top: 40%; animation-duration: 15s; }
        .particle:nth-child(8) { left: 75%; top: 60%; animation-duration: 11s; }
        .particle:nth-child(9) { left: 25%; top: 60%; animation-duration: 19s; }
        .particle:nth-child(10) { left: 45%; top: 15%; animation-duration: 13s; }

        @keyframes particleFloat {
            0% {
                transform: translateY(0) scale(.5);
                opacity: 0;
            }
            20% { opacity: 1; }
            80% { opacity: .8; }
            100% {
                transform: translateY(-180px) scale(1.3);
                opacity: 0;
            }
        }

        /* Kontainer utama */
        .login-container {
            width: 100%;
            max-width: 455px;
            padding: 42px 40px 32px;
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,.97);
            border: 1px solid rgba(255,255,255,.65);
            border-radius: 25px;
            box-shadow:
                0 30px 80px rgba(0,0,0,.35),
                0 0 40px rgba(96,165,250,.12);
            animation: cardEnter .8s cubic-bezier(.2,.8,.2,1);
        }

        @keyframes cardEnter {
            from {
                opacity: 0;
                transform: translateY(35px) scale(.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Logo */
        .logo {
            width: 76px;
            height: 76px;
            margin: 0 auto 18px;
            border-radius: 23px;
            background: linear-gradient(135deg, #60a5fa, #2563eb, #1e40af);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 37px;
            font-weight: 800;
            box-shadow: 0 12px 28px rgba(37,99,235,.35);
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }

        .top-label {
            text-align: center;
            color: #2563eb;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2.5px;
            margin-bottom: 17px;
        }

        .heading {
            text-align: center;
            margin-bottom: 28px;
        }

        .heading h1 {
            color: #0f172a;
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 9px;
        }

        .heading p {
            color: #64748b;
            font-size: 13px;
            line-height: 1.8;
        }

        .heading strong {
            color: #1e40af;
        }

        /* Notifikasi */
        .message {
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 11px;
            font-size: 13px;
            line-height: 1.5;
            animation: fadeIn .4s ease;
        }

        .error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form */
        .form-group {
            margin-bottom: 19px;
        }

        label {
            display: block;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .input-wrapper {
            position: relative;
        }

        input {
            width: 100%;
            padding: 15px 16px;
            border: 1px solid #dbe3ef;
            border-radius: 12px;
            outline: none;
            background: #f8fafc;
            color: #0f172a;
            font-size: 14px;
            transition: .25s;
        }

        input::placeholder {
            color: #9ca3af;
        }

        input:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,.12);
        }

        .password-input {
            padding-right: 80px;
        }

        .toggle-password {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #2563eb;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .forgot-password {
            display: flex;
            justify-content: flex-end;
            margin-top: -5px;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .forgot-password a {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
        }

        .forgot-password a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        /* Tombol login */
        .login-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(110deg, #3b82f6, #2563eb, #1d4ed8);
            background-size: 200% 100%;
            color: white;
            font-size: 14px;
            font-weight: 750;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 8px 20px rgba(37,99,235,.25);
        }

        .login-button:hover {
            background-position: 100% 0;
            transform: translateY(-3px);
            box-shadow: 0 13px 25px rgba(37,99,235,.35);
        }

        .login-button:active {
            transform: translateY(0);
        }

        /* Informasi keamanan */
        .security-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            color: #64748b;
            font-size: 12px;
        }

        .security-icon {
            color: #16a34a;
            font-size: 15px;
        }

        /* Pemisah */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0 19px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
        }

        .divider::before,
        .divider::after {
            content: "";
            height: 1px;
            flex: 1;
            background: #e2e8f0;
        }

        /* Tombol Home */
        .home-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            padding: 13px;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            background: #eff6ff;
            color: #1d4ed8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 750;
            transition: .3s;
        }

        .home-button:hover {
            background: #dbeafe;
            border-color: #60a5fa;
            transform: translateY(-3px);
            box-shadow: 0 7px 16px rgba(37,99,235,.12);
        }

        .home-icon {
            font-size: 17px;
        }

        /* Footer */
        .footer {
            margin-top: 26px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
            line-height: 1.9;
        }

        .footer strong {
            color: #64748b;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 34px 23px 27px;
            }

            .heading h1 {
                font-size: 24px;
            }

            .circle-one {
                width: 280px;
                height: 280px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <!-- Dekorasi background -->
    <div class="glow glow-one"></div>
    <div class="glow glow-two"></div>
    <div class="glow glow-three"></div>

    <div class="circle circle-one"></div>
    <div class="circle circle-two"></div>

    <div class="particles">
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
    </div>

    <!-- Form login -->
    <div class="login-container">

        <div class="top-label">ADMINISTRATOR ACCESS</div>

        <div class="logo">D</div>

        <div class="heading">
            <h1>Selamat Datang</h1>
            <p>
                Silakan masuk untuk mengelola data dosen
                <br>
                <strong>Sistem Informasi Data Dosen TRPL</strong>
            </p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="message error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="message success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="username">Username Admin</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan username admin"
                    autocomplete="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="password-input"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword()"
                    >
                        Lihat
                    </button>
                </div>
            </div>

            <div class="forgot-password">
                <a href="<?= site_url('forgot-password') ?>">
                    Lupa Password?
                </a>
            </div>

            <button type="submit" class="login-button">
                Masuk ke Dashboard &nbsp; →
            </button>
        </form>

        <div class="security-info">
            <span class="security-icon">🔒</span>
            <span>Halaman khusus administrator</span>
        </div>

        <div class="divider">ATAU</div>

        <a href="<?= site_url('/') ?>" class="home-button">
            <span class="home-icon">⌂</span>
            Kembali ke Halaman Utama
        </a>

        <div class="footer">
            <strong>Sistem Informasi Data Dosen TRPL</strong>
            <br>
            © 2026 Kelompok 4
        </div>

    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const button = document.querySelector('.toggle-password');

            if (password.type === 'password') {
                password.type = 'text';
                button.textContent = 'Sembunyi';
            } else {
                password.type = 'password';
                button.textContent = 'Lihat';
            }
        }
    </script>

</body>
</html>
