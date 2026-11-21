<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | Data Dosen TRPL</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            position: relative;
            overflow-x: hidden;
            background: linear-gradient(
                135deg,
                #07152e,
                #102f66,
                #164e9b,
                #0c234b
            );
            background-size: 300% 300%;
            animation: backgroundMove 12s ease infinite;
        }

        @keyframes backgroundMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Cahaya background */
        .glow {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            animation: floatGlow 9s ease-in-out infinite alternate;
        }

        .glow-one {
            width: 350px;
            height: 350px;
            top: -100px;
            left: -90px;
            background: rgba(59,130,246,.28);
        }

        .glow-two {
            width: 400px;
            height: 400px;
            right: -120px;
            bottom: -130px;
            background: rgba(14,165,233,.20);
            animation-delay: 2s;
        }

        .glow-three {
            width: 180px;
            height: 180px;
            top: 45%;
            left: 12%;
            background: rgba(96,165,250,.18);
            animation-delay: 4s;
        }

        @keyframes floatGlow {
            from { transform: translate(0,0) scale(1); }
            to { transform: translate(35px,-30px) scale(1.15); }
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

        /* Partikel bercahaya */
        .particles {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 0 12px #93c5fd;
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

        /* Kartu utama */
        .container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 455px;
            padding: 42px 40px 32px;
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

        /* Label */
        .top-label {
            text-align: center;
            color: #2563eb;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2.5px;
            margin-bottom: 18px;
        }

        /* Logo */
        .logo {
            width: 78px;
            height: 78px;
            margin: 0 auto 20px;
            border-radius: 24px;
            background: linear-gradient(135deg,#60a5fa,#2563eb,#1e40af);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            box-shadow: 0 12px 28px rgba(37,99,235,.3);
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }

        h1 {
            text-align: center;
            font-size: 26px;
            color: #0f172a;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .description {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 28px;
        }

        .description strong {
            color: #1e40af;
        }

        /* Informasi */
        .info-box {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 13px;
            margin-bottom: 22px;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            background: #eff6ff;
            color: #475569;
            font-size: 12px;
            line-height: 1.7;
        }

        .info-icon {
            font-size: 19px;
        }

        /* Pesan */
        .message {
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 11px;
            font-size: 13px;
            line-height: 1.5;
            animation: fadeIn .4s ease;
        }

        .error {
            color: #b91c1c;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .success {
            color: #166534;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 17px;
            pointer-events: none;
        }

        input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #dbe3ef;
            border-radius: 12px;
            outline: none;
            font-size: 14px;
            color: #0f172a;
            background: #f8fafc;
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

        /* Tombol verifikasi */
        .submit-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(110deg,#3b82f6,#2563eb,#1d4ed8);
            background-size: 200% 100%;
            color: white;
            font-size: 14px;
            font-weight: 750;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 8px 20px rgba(37,99,235,.25);
        }

        .submit-button:hover {
            background-position: 100% 0;
            transform: translateY(-3px);
            box-shadow: 0 13px 25px rgba(37,99,235,.35);
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

        /* Tombol kembali */
        .back-button,
        .home-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            padding: 13px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 750;
            transition: .3s;
        }

        .back-button {
            color: #1d4ed8;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .back-button:hover {
            background: #dbeafe;
            transform: translateY(-2px);
        }

        .home-button {
            margin-top: 11px;
            color: #475569;
            background: #fff;
            border: 1px solid #e2e8f0;
        }

        .home-button:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            margin-top: 25px;
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
            .container {
                padding: 34px 23px 27px;
            }

            h1 {
                font-size: 23px;
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

    <!-- Background dekoratif -->
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

    <!-- Kartu lupa password -->
    <div class="container">

        <div class="top-label">ACCOUNT RECOVERY</div>

        <div class="logo">🔐</div>

        <h1>Lupa Password?</h1>

        <p class="description">
            Jangan khawatir! Masukkan Gmail Admin yang
            sudah terdaftar pada
            <br>
            <strong>Sistem Informasi Data Dosen TRPL</strong>
        </p>

        <div class="info-box">
            <span class="info-icon">✉️</span>
            <span>
                Link pemulihan password akan dikirimkan
                ke alamat Gmail Admin yang terdaftar.
            </span>
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

        <form action="<?= site_url('forgot-password') ?>" method="post">

            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Gmail Admin</label>

                <div class="input-wrapper">
                    <span class="input-icon">✉️</span>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="nama@gmail.com"
                        autocomplete="email"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="submit-button">
                Verifikasi Gmail &nbsp; →
            </button>

        </form>

        <div class="divider">NAVIGASI</div>

        <a href="<?= site_url('login') ?>" class="back-button">
            ← Kembali ke Login Admin
        </a>

        <a href="<?= site_url('/') ?>" class="home-button">
            ⌂ Kembali ke Halaman Utama
        </a>

        <div class="footer">
            <strong>Sistem Informasi Data Dosen TRPL</strong>
            <br>
            © 2026 Kelompok 4
        </div>

    </div>

</body>
</html>