<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru | Data Dosen TRPL</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 430px;
            background: white;
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }

        .logo {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            border-radius: 20px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        h1 {
            text-align: center;
            color: #0f172a;
            font-size: 24px;
            margin-bottom: 12px;
        }

        .description {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .message {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 9px;
            font-size: 13px;
        }

        .error {
            color: #b91c1c;
            background: #fef2f2;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 22px;
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="logo">🔐</div>

    <h1>Buat Password Baru</h1>

    <p class="description">
        Silakan buat password baru untuk akun
        Admin Data Dosen TRPL.
    </p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="message error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('reset-password/' . $token) ?>" method="post">

        <?= csrf_field() ?>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                placeholder="Minimal 8 karakter"
                autocomplete="new-password"
                required
            >
        </div>

        <div class="form-group">
            <label for="confirm_password">Konfirmasi Password Baru</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                minlength="8"
                placeholder="Ulangi password baru"
                autocomplete="new-password"
                required
            >
        </div>

        <button type="submit">
            Simpan Password Baru
        </button>

    </form>

    <a href="<?= site_url('login') ?>" class="back">
        ← Kembali ke Login
    </a>

</div>

</body>
</html>
