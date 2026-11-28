
<?php
/**
 * Halaman Integrasi API
 * Data dari Kelompok 2, Kelompok 3, dan Kelompok 4.
 */

$statusApi = $status_api ?? [];

$dosen       = $dosen ?? [];
$matkul      = $matkul ?? [];
$dosenApi    = $dosen_api ?? [];
$pengampu    = $pengampu ?? [];
$jadwal      = $jadwal ?? [];

$totalDosen    = $total_dosen ?? count($dosen);
$totalMatkul   = $total_matkul ?? count($matkul);
$totalDosenApi = $total_dosen_api ?? count($dosenApi);
$totalPengampu = $total_pengampu ?? count($pengampu);
$totalJadwal   = $total_jadwal ?? count($jadwal);

$diagnostik = $diagnostik ?? [];

$semuaTerhubung = !in_array(false, $statusApi, true);

function formatStatusIntegrasi($status)
{
    return $status
        ? '<span class="status-badge online"><span class="status-dot"></span> Terhubung</span>'
        : '<span class="status-badge offline"><span class="status-dot"></span> Tidak Terhubung</span>';
}

function nilaiIntegrasi($value)
{
    return esc($value ?? '-');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title ?? 'Integrasi API') ?> - Data Dosen TRPL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #112e50;
            --blue: #2864e8;
            --blue-light: #edf4ff;
            --text: #1b3150;
            --muted: #8292a9;
            --border: #e8edf5;
            --background: #f4f7fc;
            --green: #16a765;
            --red: #e45454;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
            font-size: 13px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .sidebar {
            width: 255px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--navy);
            color: white;
            padding: 25px 18px;
            display: flex;
            flex-direction: column;
            z-index: 10;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 5px 8px 38px;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            background: #3476f6;
            border-radius: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 23px;
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
        }

        .brand-subtitle {
            font-size: 10px;
            color: #c5d6ef;
            margin-top: 5px;
        }

        .menu-label {
            font-size: 10px;
            font-weight: 800;
            color: #8faed4;
            letter-spacing: 1.3px;
            margin: 0 10px 15px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 15px 14px;
            border-radius: 12px;
            color: #e1eaf7;
            font-weight: 600;
            transition: .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: var(--blue);
            color: white;
        }

        .menu-icon {
            font-size: 18px;
            width: 22px;
            text-align: center;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.15);
            padding: 23px 8px 5px;
            color: #c6d7ef;
            font-size: 11px;
            line-height: 1.9;
        }

        .sidebar-footer strong {
            color: white;
        }

        .main {
            margin-left: 255px;
            padding: 32px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 27px;
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 8px;
        }

        .page-title {
            font-size: 25px;
            font-weight: 800;
            color: var(--navy);
        }

        .page-description {
            color: var(--muted);
            margin-top: 7px;
            line-height: 1.6;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            padding: 11px 15px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            border: 1px solid var(--border);
            background: white;
            color: var(--text);
        }

        .btn-primary {
            background: var(--blue);
            color: white;
            border-color: var(--blue);
        }

        .btn:hover {
            opacity: .88;
        }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 29px 31px;
            border-radius: 19px;
            color: white;
            background: linear-gradient(115deg, #153c70, #2864e8 75%, #4785f6);
            box-shadow: 0 12px 28px rgba(39, 99, 216, .15);
            margin-bottom: 24px;
        }

        .hero::after {
            content: "";
            width: 210px;
            height: 210px;
            position: absolute;
            right: -65px;
            top: -100px;
            border-radius: 50%;
            background: rgba(255,255,255,.10);
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            border-radius: 30px;
            background: rgba(255,255,255,.13);
            border: 1px solid rgba(255,255,255,.2);
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 17px;
        }

        .hero h2 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .hero p {
            color: #e4edff;
            max-width: 650px;
            line-height: 1.8;
        }

        .hero-icon {
            position: absolute;
            right: 65px;
            bottom: 24px;
            font-size: 57px;
            opacity: .9;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 27px 0 15px;
            gap: 12px;
        }

        .section-heading h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--navy);
        }

        .section-heading p {
            font-size: 11px;
            color: var(--muted);
            margin-top: 5px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 17px rgba(27, 55, 91, .035);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
        }

        .stat-icon {
            width: 39px;
            height: 39px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 19px;
            background: var(--blue-light);
        }

        .stat-number {
            font-size: 29px;
            font-weight: 800;
            margin: 15px 0 6px;
            color: var(--navy);
        }

        .stat-caption {
            font-size: 10px;
            color: var(--muted);
        }

        .stat-line {
            height: 4px;
            border-radius: 10px;
            background: #eaf0fa;
            margin-top: 17px;
            overflow: hidden;
        }

        .stat-line span {
            display: block;
            height: 100%;
            background: #3478f6;
            width: 100%;
            border-radius: inherit;
        }

        .connection-card,
        .content-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 17px rgba(27, 55, 91, .035);
            margin-bottom: 20px;
        }

        .connection-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .connection-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fcfdff;
        }

        .connection-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .connection-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: #edf4ff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
        }

        .connection-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
        }

        .connection-group {
            font-size: 10px;
            color: var(--muted);
            margin-top: 5px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 700;
            border-radius: 30px;
            padding: 7px 10px;
            white-space: nowrap;
        }

        .status-badge.online {
            color: #12864f;
            background: #e9f9f0;
        }

        .status-badge.offline {
            color: #cf4141;
            background: #fff0f0;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .alert-status {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            margin-top: 18px;
            background: <?= $semuaTerhubung ? '#eaf9f0' : '#fff5ed' ?>;
            color: <?= $semuaTerhubung ? '#14834e' : '#bd6a26' ?>;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.6;
        }

        .content-card {
            padding: 0;
            overflow: hidden;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 22px;
            border-bottom: 1px solid var(--border);
            gap: 12px;
        }

        .card-header h3 {
            font-size: 14px;
            font-weight: 800;
            color: var(--navy);
        }

        .card-header p {
            color: var(--muted);
            font-size: 10px;
            margin-top: 5px;
        }

        .count-badge {
            background: var(--blue-light);
            color: var(--blue);
            border-radius: 20px;
            padding: 7px 11px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 620px;
        }

        thead {
            background: #f7f9fd;
        }

        th {
            padding: 14px 17px;
            text-align: left;
            color: #73839b;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        td {
            padding: 14px 17px;
            border-top: 1px solid #f0f3f8;
            font-size: 11px;
            color: #40516b;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #f8fbff;
        }

        .code-pill {
            display: inline-block;
            background: #edf4ff;
            color: #2864d9;
            border-radius: 6px;
            padding: 5px 8px;
            font-size: 10px;
            font-weight: 700;
        }

        .match-pill {
            display: inline-block;
            background: #e9f9f0;
            color: #12864f;
            border-radius: 20px;
            padding: 6px 9px;
            font-size: 10px;
            font-weight: 700;
        }

        .empty-state {
            text-align: center;
            padding: 35px 20px;
            color: var(--muted);
        }

        .empty-state span {
            display: block;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .diagnostic-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            padding: 20px 22px;
        }

        .diagnostic-item {
            padding: 13px;
            background: #f8faff;
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .diagnostic-item strong {
            display: block;
            font-size: 11px;
            margin-bottom: 6px;
            color: var(--navy);
        }

        .diagnostic-item p {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .footer {
            text-align: center;
            padding: 20px 0 5px;
            color: var(--muted);
            font-size: 10px;
        }

        @media (max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 15px;
            }

            .brand {
                padding-bottom: 15px;
            }

            .menu-label,
            .sidebar-footer {
                display: none;
            }

            .menu {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .menu a {
                padding: 10px;
                font-size: 10px;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            .hero-icon {
                display: none;
            }

            .connection-grid,
            .diagnostic-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 22px;
            }

            .hero h2 {
                font-size: 19px;
            }

            .connection-item {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar">

    <div class="brand">
        <div class="brand-icon">🎓</div>
        <div>
            <div class="brand-name">Data Dosen</div>
            <div class="brand-subtitle">TRPL Information System</div>
        </div>
    </div>

    <div class="menu-label">MENU UTAMA</div>

    <nav class="menu">

        <a href="<?= site_url('dashboard') ?>">
            <span class="menu-icon">🏠</span>
            Dashboard
        </a>

        <a href="<?= site_url('dosen') ?>">
            <span class="menu-icon">👨‍🏫</span>
            Data Dosen
        </a>

        <a href="<?= site_url('api-explorer') ?>">
            <span class="menu-icon">🔌</span>
            API Explorer
        </a>

        <a href="<?= site_url('integrasi') ?>" class="active">
            <span class="menu-icon">🔗</span>
            Integrasi API
        </a>

    </nav>

    <div class="sidebar-footer">
        <strong>Kelompok 4</strong><br>
        Teknologi Rekayasa<br>
        Perangkat Lunak
    </div>

</aside>


<!-- MAIN CONTENT -->
<main class="main">

    <!-- HEADER -->
    <header class="topbar">

        <div>
            <div class="breadcrumb">
                Dashboard / Integrasi API
            </div>

            <h1 class="page-title">Integrasi API</h1>

            <p class="page-description">
                Monitoring dan penggabungan data dari Kelompok 2,
                Kelompok 3, dan Kelompok 4.
            </p>
        </div>

        <div class="top-actions">

            <a href="<?= site_url('dashboard') ?>" class="btn">
                ← Dashboard
            </a>

            <a href="<?= site_url('integrasi') ?>" class="btn btn-primary">
                ↻ Muat Ulang
            </a>

        </div>

    </header>


    <!-- HERO -->
    <section class="hero">

        <div class="hero-label">
            <span>●</span>
            SISTEM INFORMASI DATA DOSEN TRPL
        </div>

        <h2>Integrasi Data Antar Kelompok 🔗</h2>

        <p>
            Halaman ini menampilkan hasil integrasi data dosen,
            mata kuliah, pengampu, dan jadwal perkuliahan
            melalui REST API dari tiga kelompok.
        </p>

        <div class="hero-icon">🎓</div>

    </section>


    <!-- STATISTIK -->
    <div class="section-heading">

        <div>
            <h3>Ringkasan Data Integrasi</h3>
            <p>Total data yang berhasil diperoleh dari masing-masing sumber.</p>
        </div>

    </div>

    <section class="stats-grid">

        <div class="stat-card">

            <div class="stat-top">
                <span class="stat-title">Total Dosen Lokal</span>
                <div class="stat-icon">👨‍🏫</div>
            </div>

            <div class="stat-number">
                <?= number_format($totalDosen) ?>
            </div>

            <div class="stat-caption">Kelompok 4</div>

            <div class="stat-line"><span></span></div>

        </div>


        <div class="stat-card">

            <div class="stat-top">
                <span class="stat-title">Total Mata Kuliah</span>
                <div class="stat-icon">📚</div>
            </div>

            <div class="stat-number">
                <?= number_format($totalMatkul) ?>
            </div>

            <div class="stat-caption">Kelompok 3</div>

            <div class="stat-line"><span></span></div>

        </div>


        <div class="stat-card">

            <div class="stat-top">
                <span class="stat-title">Total Pengampu</span>
                <div class="stat-icon">📝</div>
            </div>

            <div class="stat-number">
                <?= number_format($totalPengampu) ?>
            </div>

            <div class="stat-caption">Kelompok 2</div>

            <div class="stat-line"><span></span></div>

        </div>


        <div class="stat-card">

            <div class="stat-top">
                <span class="stat-title">Total Jadwal</span>
                <div class="stat-icon">📅</div>
            </div>

            <div class="stat-number">
                <?= number_format($totalJadwal) ?>
            </div>

            <div class="stat-caption">Kelompok 2</div>

            <div class="stat-line"><span></span></div>

        </div>

    </section>


    <!-- STATUS API -->
    <div class="section-heading">

        <div>
            <h3>Status Koneksi API</h3>
            <p>Pemeriksaan konektivitas setiap sumber data.</p>
        </div>

    </div>

    <section class="connection-card">

        <div class="connection-grid">

            <div class="connection-item">

                <div class="connection-info">
                    <div class="connection-icon">👨‍🏫</div>

                    <div>
                        <div class="connection-name">API Dosen Lokal</div>
                        <div class="connection-group">Kelompok 4</div>
                    </div>
                </div>

                <?= formatStatusIntegrasi($statusApi['dosen'] ?? false) ?>

            </div>


            <div class="connection-item">

                <div class="connection-info">
                    <div class="connection-icon">📚</div>

                    <div>
                        <div class="connection-name">API Mata Kuliah</div>
                        <div class="connection-group">Kelompok 3</div>
                    </div>
                </div>

                <?= formatStatusIntegrasi($statusApi['matkul'] ?? false) ?>

            </div>


            <div class="connection-item">

                <div class="connection-info">
                    <div class="connection-icon">👥</div>

                    <div>
                        <div class="connection-name">API Dosen</div>
                        <div class="connection-group">Kelompok 2</div>
                    </div>
                </div>

                <?= formatStatusIntegrasi($statusApi['dosen_api'] ?? false) ?>

            </div>


            <div class="connection-item">

                <div class="connection-info">
                    <div class="connection-icon">📝</div>

                    <div>
                        <div class="connection-name">API Pengampu</div>
                        <div class="connection-group">Kelompok 2</div>
                    </div>
                </div>

                <?= formatStatusIntegrasi($statusApi['pengampu'] ?? false) ?>

            </div>


            <div class="connection-item">

                <div class="connection-info">
                    <div class="connection-icon">📅</div>

                    <div>
                        <div class="connection-name">API Jadwal</div>
                        <div class="connection-group">Kelompok 2</div>
                    </div>
                </div>

                <?= formatStatusIntegrasi($statusApi['jadwal'] ?? false) ?>

            </div>

        </div>

        <div class="alert-status">

            <span style="font-size:18px">
                <?= $semuaTerhubung ? '✓' : '⚠' ?>
            </span>

            <span>
                <?= $semuaTerhubung
                    ? 'Seluruh sumber data berhasil terhubung dan dapat diakses.'
                    : 'Terdapat sumber data yang belum berhasil terhubung. Periksa kembali koneksi API.' ?>
            </span>

        </div>

    </section>


    <!-- TABEL PENGAMPU -->
    <div class="section-heading">

        <div>
            <h3>Data Pengampu Perkuliahan</h3>
            <p>Data pengampu yang diperoleh dari API Kelompok 2.</p>
        </div>

    </div>

    <section class="content-card">

        <div class="card-header">

            <div>
                <h3>Daftar Pengampu</h3>
                <p>Informasi dosen, mata kuliah, kelas, dan semester.</p>
            </div>

            <span class="count-badge">
                <?= number_format($totalPengampu) ?> Data
            </span>

        </div>

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Pengampu</th>
                        <th>Kode Dosen</th>
                        <th>Nama Dosen</th>
                        <th>Mata Kuliah</th>
                        <th>Kelas</th>
                        <th>Semester</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($pengampu)): ?>

                        <?php foreach (array_slice($pengampu, 0, 15) as $i => $item): ?>

                            <tr>
                                <td><?= $i + 1 ?></td>

                                <td>
                                    <span class="code-pill">
                                        <?= nilaiIntegrasi($item['id_pengampu'] ?? '-') ?>
                                    </span>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['kode_dosen'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['nama_dosen'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['nama_matkul'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['nama_kelas'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['semester_kuliah'] ?? '-') ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <span>📭</span>
                                    Data pengampu belum tersedia.
                                </div>
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>


    <!-- TABEL JADWAL -->
    <div class="section-heading">

        <div>
            <h3>Jadwal Perkuliahan</h3>
            <p>Informasi jadwal kuliah dari API Kelompok 2.</p>
        </div>

    </div>

    <section class="content-card">

        <div class="card-header">

            <div>
                <h3>Daftar Jadwal Kuliah</h3>
                <p>Hari, waktu, kelas, dan ruang perkuliahan.</p>
            </div>

            <span class="count-badge">
                <?= number_format($totalJadwal) ?> Data
            </span>

        </div>

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Jadwal</th>
                        <th>ID Pengampu</th>
                        <th>Kode Dosen</th>
                        <th>Mata Kuliah</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Ruang</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($jadwal)): ?>

                        <?php foreach (array_slice($jadwal, 0, 15) as $i => $item): ?>

                            <tr>
                                <td><?= $i + 1 ?></td>

                                <td><?= nilaiIntegrasi($item['id_jadwal'] ?? '-') ?></td>

                                <td><?= nilaiIntegrasi($item['id_pengampu'] ?? '-') ?></td>

                                <td>
                                    <span class="code-pill">
                                        <?= nilaiIntegrasi($item['kode_dosen'] ?? '-') ?>
                                    </span>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['nama_matkul'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['nama_kelas'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['hari'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['jam_mulai'] ?? '-') ?>
                                    -
                                    <?= nilaiIntegrasi($item['jam_selesai'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= nilaiIntegrasi($item['kode_ruang'] ?? '-') ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <span>📅</span>
                                    Data jadwal belum tersedia.
                                </div>
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>


    <!-- DIAGNOSTIK -->
    <div class="section-heading">

        <div>
            <h3>Informasi Diagnostik</h3>
            <p>Pesan respons dari masing-masing API.</p>
        </div>

    </div>

    <section class="content-card">

        <div class="card-header">

            <div>
                <h3>Hasil Pemeriksaan API</h3>
                <p>Informasi proses pengambilan data.</p>
            </div>

            <span class="count-badge">Diagnostic</span>

        </div>

        <div class="diagnostic-grid">

            <div class="diagnostic-item">
                <strong>API Mata Kuliah</strong>
                <p><?= nilaiIntegrasi($diagnostik['matkul'] ?? 'Belum ada informasi') ?></p>
            </div>

            <div class="diagnostic-item">
                <strong>API Dosen Kelompok 2</strong>
                <p><?= nilaiIntegrasi($diagnostik['dosen'] ?? 'Belum ada informasi') ?></p>
            </div>

            <div class="diagnostic-item">
                <strong>API Pengampu</strong>
                <p><?= nilaiIntegrasi($diagnostik['pengampu'] ?? 'Belum ada informasi') ?></p>
            </div>

            <div class="diagnostic-item">
                <strong>API Jadwal</strong>
                <p><?= nilaiIntegrasi($diagnostik['jadwal'] ?? 'Belum ada informasi') ?></p>
            </div>

        </div>

    </section>


    <!-- FOOTER -->
    <footer class="footer">
        Data Dosen TRPL &copy; <?= date('Y') ?> |
        Sistem Informasi Teknologi Rekayasa Perangkat Lunak
    </footer>

</main>

</body>
</html>
