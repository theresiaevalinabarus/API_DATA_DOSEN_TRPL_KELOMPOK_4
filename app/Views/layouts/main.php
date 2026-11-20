
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title ?? 'Data Dosen TRPL') ?></title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy: #102d50;
            --navy-light: #183e6d;
            --primary: #2864e8;
            --background: #f3f6fc;
            --text: #203653;
            --muted: #8796aa;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
            font-size: 14px;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 255px;
            height: 100vh;
            background: var(--navy);
            color: white;
            padding: 25px 18px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: .3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 8px 38px;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            background: #3277f5;
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 23px;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
            margin: 0;
        }

        .brand-subtitle {
            color: #b9cce6;
            font-size: 11px;
            margin-top: 4px;
        }

        .menu-label {
            color: #9bb5d5;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            padding: 0 10px;
            margin-bottom: 15px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            border-radius: 11px;
            color: #d5e3f7;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: .2s ease;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,.09);
            color: white;
        }

        .sidebar-menu a.active {
            background: var(--primary);
            color: white;
            font-weight: 700;
        }

        .menu-icon {
            font-size: 17px;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 20px 8px 5px;
            border-top: 1px solid rgba(255,255,255,.13);
            color: #c4d5ec;
            font-size: 11px;
            line-height: 1.9;
        }

        .sidebar-footer strong {
            color: white;
        }

        /* MAIN AREA */
        .main-wrapper {
            margin-left: 255px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */
        .topbar {
            min-height: 75px;
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .page-info h1 {
            font-size: 23px;
            font-weight: 800;
            color: #17365e;
            margin: 0 0 5px;
        }

        .page-info p {
            color: var(--muted);
            font-size: 12px;
            margin: 0;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 10px 15px;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(30,50,80,.04);
        }

        .admin-icon {
            width: 38px;
            height: 38px;
            background: #e9f0ff;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 17px;
        }

        .admin-name {
            font-size: 12px;
            font-weight: 700;
            color: #17365e;
        }

        .admin-role {
            font-size: 10px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* CONTENT */
        .main-content {
            padding: 12px 32px 35px;
            flex: 1;
            min-width: 0;
        }

        /* COMMON COMPONENTS */
        .card {
            border: 1px solid #edf1f7;
            border-radius: 16px;
            box-shadow: 0 5px 22px rgba(25,45,75,.05);
        }

        .form-control,
        .form-select {
            border-color: #dce4ef;
            border-radius: 9px;
        }

        .btn {
            border-radius: 9px;
            font-weight: 600;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f4f7fb;
            color: #52627a;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid #edf1f7;
        }

        .table td {
            vertical-align: middle;
            color: #344563;
        }

        /* MOBILE */
        .mobile-menu-btn {
            display: none;
            border: 0;
            background: white;
            padding: 9px 12px;
            border-radius: 9px;
            font-size: 20px;
            color: var(--navy);
        }

        .sidebar-overlay {
            display: none;
        }

        @media(max-width: 900px) {

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.4);
                z-index: 999;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: inline-block;
            }

            .topbar {
                padding: 14px 20px;
            }

            .main-content {
                padding: 15px 20px 30px;
            }
        }

        @media(max-width: 500px) {

            .page-info h1 {
                font-size: 19px;
            }

            .admin-profile {
                padding: 8px;
            }

            .admin-name,
            .admin-role {
                display: none;
            }

            .main-content {
                padding: 12px;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">

            <div class="brand-icon">
                🎓
            </div>

            <div>
                <h2 class="brand-name">Data Dosen</h2>
                <div class="brand-subtitle">
                    TRPL Information System
                </div>
            </div>

        </div>

        <div class="menu-label">
            MENU UTAMA
        </div>

        <nav class="sidebar-menu">

            <a
                href="<?= site_url('dashboard') ?>"
                class="<?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>">

                <span class="menu-icon">📊</span>
                Dashboard

            </a>

            <a
                href="<?= site_url('dosen') ?>"
                class="<?= ($active ?? '') === 'dosen' ? 'active' : '' ?>">

                <span class="menu-icon">👨‍🏫</span>
                Data Dosen

            </a>

        </nav>

        <div class="sidebar-footer">
            <strong>Kelompok 4</strong><br>
            Teknologi Rekayasa<br>
            Perangkat Lunak
        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"
         onclick="toggleSidebar()"></div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">

        <!-- HEADER -->
        <header class="topbar">

            <div class="d-flex align-items-center gap-3">

                <button
                    class="mobile-menu-btn"
                    type="button"
                    onclick="toggleSidebar()">

                    ☰

                </button>

                <div class="page-info">
                    <h1><?= esc($heading ?? 'Dashboard') ?></h1>

                    <p>
                        <?= esc($subtitle ?? 'Sistem Informasi Data Dosen TRPL') ?>
                    </p>
                </div>

            </div>

            <div class="admin-profile">

                <div class="admin-icon">
                    👤
                </div>

                <div>
                    <div class="admin-name">
                        Administrator
                    </div>

                    <div class="admin-role">
                        Pengelola Sistem
                    </div>
                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="main-content">

            <?= $this->renderSection('content') ?>

        </main>

    </div>

    <!-- BOOTSTRAP JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>

</body>
</html>
