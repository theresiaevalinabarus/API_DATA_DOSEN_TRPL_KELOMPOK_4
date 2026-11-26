
<?php

$dosenList = $dosen ?? [];
$totalDosen = count($dosenList);

$aktif = count(array_filter($dosenList, function ($item) {
    return strtolower($item['nama_status_aktivitas'] ?? $item['status_aktivitas'] ?? '') === 'aktif';
}));

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen | TRPL Information System</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* ANIMASI */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-25px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-7px);
            }
        }

        @keyframes glow {
            0%, 100% {
                box-shadow: 0 5px 15px rgba(37,99,235,.15);
            }
            50% {
                box-shadow: 0 8px 25px rgba(37,99,235,.35);
            }
        }

        .sidebar {
            width: 255px;
            min-width: 255px;
            background: linear-gradient(180deg, #102F52 0%, #0b2340 100%);
            animation: slideIn .6s ease;
        }

        .main-content {
            min-width: 0;
            animation: fadeIn .65s ease;
        }

        .logo-box {
            animation: float 3s ease-in-out infinite;
        }

        .menu-link {
            position: relative;
            overflow: hidden;
            transition: all .3s ease;
        }

        .menu-link:hover {
            transform: translateX(5px);
            background: rgba(59,130,246,.25);
        }

        .menu-active {
            background: linear-gradient(120deg, #2563eb, #1d4ed8);
            box-shadow: 0 8px 20px rgba(37,99,235,.25);
        }

        .menu-active:hover {
            transform: translateX(4px);
        }

        .sidebar-action {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px 14px;
            border-radius: 11px;
            text-decoration: none;
            color: #dbeafe;
            font-size: 13px;
            font-weight: 600;
            transition: all .3s ease;
        }

        .sidebar-action:hover {
            transform: translateX(5px);
            background: rgba(255,255,255,.12);
            color: white;
        }

        .sidebar-action .action-icon {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.1);
            border-radius: 9px;
            font-size: 17px;
            flex-shrink: 0;
        }

        .logout-action {
            color: #fecaca;
        }

        .logout-action:hover {
            background: rgba(239,68,68,.2);
            color: white;
        }

        .logout-action .action-icon {
            background: rgba(239,68,68,.15);
        }

        /* KARTU STATISTIK */
        .stat-card {
            animation: fadeIn .7s ease backwards;
            transition: all .3s ease;
        }

        .stat-card:nth-child(1) {
            animation-delay: .1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: .2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: .3s;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(15,23,42,.09);
        }

        .stat-icon {
            transition: all .35s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotate(8deg) scale(1.1);
        }

        .table-card {
            animation: fadeIn .8s ease .2s backwards;
        }

        /* TABEL */
        .table-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .table-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .data-table th,
        .data-table td {
            white-space: nowrap;
        }

        .data-table tbody tr {
            transition: background .25s ease;
        }

        .data-table tbody tr:hover {
            background: #eff6ff;
        }

        .action-button {
            transition: all .25s ease;
        }

        .action-button:hover {
            transform: translateY(-2px);
        }

        .primary-button {
            transition: all .3s ease;
        }

        .primary-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 22px rgba(37,99,235,.3);
        }

        .flash-message {
            animation: fadeIn .4s ease;
        }

        .profile-avatar {
            transition: all .3s ease;
        }

        .profile-avatar:hover {
            transform: rotate(10deg) scale(1.08);
        }

        /* HEADER */
        .page-header {
            position: relative;
            overflow: hidden;
            background: linear-gradient(120deg, #ffffff, #eff6ff);
            border: 1px solid #dbeafe;
            border-radius: 18px;
            padding: 22px;
        }

        .page-header::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: -65px;
            top: -90px;
            border-radius: 50%;
            background: rgba(59,130,246,.08);
            pointer-events: none;
        }

        .status-dot {
            animation: glow 2s ease-in-out infinite;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 75px;
                min-width: 75px;
            }

            .sidebar-text {
                display: none !important;
            }

            .sidebar-action {
                justify-content: center;
                padding: 10px 5px;
            }

            .sidebar-action .action-icon {
                margin: auto;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 14px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="sidebar text-white flex flex-col justify-between
                  sticky top-0 h-screen self-start flex-shrink-0 overflow-y-auto">

        <div>

            <!-- LOGO -->
            <div class="px-5 py-8">
                <div class="flex items-center gap-3">

                    <div class="logo-box w-11 h-11 rounded-xl bg-blue-500
                                flex items-center justify-center text-xl shadow-lg">
                        🎓
                    </div>

                    <div class="sidebar-text">
                        <h1 class="font-extrabold text-lg">Data Dosen</h1>
                        <p class="text-blue-200 text-xs">
                            TRPL Information System
                        </p>
                    </div>

                </div>
            </div>

            <!-- MENU UTAMA -->
            <div class="px-4">

                <p class="sidebar-text text-[11px] font-bold tracking-widest
                          text-blue-300 mb-4 px-3">
                    MENU UTAMA
                </p>

                <a href="<?= site_url('dashboard') ?>"
                   class="menu-link flex items-center gap-3 px-4 py-4
                          rounded-xl text-blue-100 mb-2">

                    <span class="text-lg">📊</span>
                    <span class="sidebar-text text-sm font-semibold">
                        Dashboard
                    </span>
                </a>

                <a href="<?= site_url('dosen') ?>"
                   class="menu-link menu-active flex items-center gap-3
                          px-4 py-4 rounded-xl text-white mb-2">

                    <span class="text-lg">👨‍🏫</span>
                    <span class="sidebar-text text-sm font-semibold">
                        Data Dosen
                    </span>
                </a>

            </div>

        </div>

        <!-- SIDEBAR BOTTOM -->
        <div class="mt-8">

            <div class="px-4 pb-5 space-y-2">

                <p class="sidebar-text text-[10px] uppercase tracking-widest
                          font-bold text-blue-300 px-3 mb-3">
                    NAVIGASI
                </p>

                <!-- HOME -->
                <a href="<?= site_url('/') ?>"
                   class="sidebar-action"
                   title="Kembali ke halaman utama">

                    <span class="action-icon">🏠</span>

                    <span class="sidebar-text">
                        Kembali ke Home
                    </span>

                </a>

                <!-- LOGOUT -->
                <a href="<?= site_url('logout') ?>"
                   class="sidebar-action logout-action"
                   title="Keluar dari akun Admin"
                   onclick="return confirmLogout(event)">

                    <span class="action-icon">🚪</span>

                    <span class="sidebar-text">
                        Logout
                    </span>

                </a>

            </div>

            <!-- FOOTER SIDEBAR -->
            <div class="px-6 py-6 border-t border-blue-900">

                <div class="sidebar-text">
                    <p class="font-bold text-xs">Kelompok 4</p>

                    <p class="text-blue-200 text-xs mt-2 leading-5">
                        Teknologi Rekayasa<br>
                        Perangkat Lunak
                    </p>
                </div>

                <div class="hidden sidebar-mini-footer text-center text-xs font-bold text-blue-200">
                    K4
                </div>

            </div>

        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main-content flex-1 p-5 md:p-8">

        <!-- HEADER -->
        <header class="page-header flex flex-col sm:flex-row sm:items-center
                       sm:justify-between gap-4 mb-8">

            <div class="relative z-10">

                <p class="text-xs font-semibold text-blue-600 mb-1">
                    TRPL INFORMATION SYSTEM
                </p>

                <h2 class="text-2xl font-extrabold text-slate-800">
                    Data Dosen
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Kelola dan lihat informasi seluruh dosen.
                </p>

            </div>

            <!-- ADMIN PROFILE -->
            <div class="relative z-10 flex items-center gap-3">

                <div class="profile-avatar w-11 h-11 rounded-full bg-blue-100
                            flex items-center justify-center text-blue-700 font-bold">
                    K4
                </div>

                <div>
                    <p class="text-sm font-bold text-slate-700">
                        <?= esc(session()->get('nama_admin') ?? 'Kelompok 4') ?>
                    </p>

                    <p class="text-xs text-slate-400">
                        Administrator
                    </p>
                </div>

            </div>

        </header>


        <!-- FLASH MESSAGE -->
        <?php if (session()->getFlashdata('success')): ?>

            <div class="flash-message mb-5 p-4 bg-green-50 border
                        border-green-200 text-green-700 rounded-xl text-sm">

                <span class="font-bold">✓ Berhasil!</span>
                <?= esc(session()->getFlashdata('success')) ?>

            </div>

        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>

            <div class="flash-message mb-5 p-4 bg-red-50 border
                        border-red-200 text-red-700 rounded-xl text-sm">

                <span class="font-bold">⚠ Perhatian!</span>
                <?= esc(session()->getFlashdata('error')) ?>

            </div>

        <?php endif; ?>


        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
                    gap-5 mb-7">

            <!-- TOTAL DOSEN -->
            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm
                        border border-slate-200">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500 font-medium">
                            Total Data Dosen
                        </p>

                        <h3 class="text-3xl font-extrabold text-slate-800 mt-2">
                            <?= $totalDosen ?>
                        </h3>

                        <p class="text-xs text-slate-400 mt-2">
                            Seluruh data dosen
                        </p>
                    </div>

                    <div class="stat-icon w-14 h-14 rounded-2xl bg-blue-50
                                flex items-center justify-center text-2xl">
                        👨‍🏫
                    </div>

                </div>

            </div>


            <!-- DOSEN AKTIF -->
            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm
                        border border-slate-200">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500 font-medium">
                            Dosen Aktif
                        </p>

                        <h3 class="text-3xl font-extrabold text-green-600 mt-2">
                            <?= $aktif ?>
                        </h3>

                        <p class="text-xs text-slate-400 mt-2">
                            Status aktivitas aktif
                        </p>
                    </div>

                    <div class="stat-icon w-14 h-14 rounded-2xl bg-green-50
                                flex items-center justify-center text-2xl">
                        ✓
                    </div>

                </div>

            </div>


            <!-- DOSEN TIDAK AKTIF -->
            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm
                        border border-slate-200">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500 font-medium">
                            Dosen Tidak Aktif
                        </p>

                        <h3 class="text-3xl font-extrabold text-orange-500 mt-2">
                            <?= $totalDosen - $aktif ?>
                        </h3>

                        <p class="text-xs text-slate-400 mt-2">
                            Status selain aktif
                        </p>
                    </div>

                    <div class="stat-icon w-14 h-14 rounded-2xl bg-orange-50
                                flex items-center justify-center text-2xl">
                        ◷
                    </div>

                </div>

            </div>

        </div>


        <!-- TABLE CARD -->
        <section class="table-card bg-white rounded-2xl shadow-sm
                        border border-slate-200 overflow-hidden">

            <!-- TABLE HEADING -->
            <div class="p-6 border-b border-slate-100">

                <div class="flex flex-col lg:flex-row lg:items-center
                            lg:justify-between gap-4">

                    <div>
                        <h3 class="text-lg font-bold text-slate-800">
                            Daftar Dosen
                        </h3>

                        <p class="text-sm text-slate-400 mt-1">
                            Total hasil: <?= $totalDosen ?> dosen
                        </p>
                    </div>


                    <div class="flex flex-col sm:flex-row gap-3">

                        <!-- SEARCH -->
                        <form action="<?= site_url('dosen') ?>"
                              method="GET"
                              class="flex gap-2">

                            <input
                                type="text"
                                name="keyword"
                                value="<?= esc($keyword ?? '') ?>"
                                placeholder="Cari nama, NIP, kode..."
                                class="w-full sm:w-64 px-4 py-2.5
                                       border border-slate-200 rounded-xl
                                       text-sm outline-none
                                       focus:ring-2 focus:ring-blue-500"
                            >

                            <button
                                type="submit"
                                class="action-button px-4 py-2.5
                                       bg-slate-100 hover:bg-slate-200
                                       rounded-xl text-sm font-semibold
                                       text-slate-700"
                            >
                                Cari
                            </button>

                        </form>


                        <!-- TAMBAH DOSEN -->
                        <a
                            href="<?= site_url('dosen/create') ?>"
                            class="primary-button flex items-center
                                   justify-center gap-2 px-5 py-2.5
                                   bg-blue-600 hover:bg-blue-700
                                   text-white rounded-xl text-sm
                                   font-bold shadow-lg shadow-blue-600/20"
                        >
                            <span class="text-lg">+</span>
                            Tambah Dosen
                        </a>

                    </div>

                </div>

            </div>


            <!-- TABLE -->
            <div class="table-scroll overflow-x-auto">

                <table class="data-table w-full text-sm">

                    <thead class="bg-slate-50 text-slate-500
                                  text-xs uppercase tracking-wide">

                        <tr>
                            <th class="px-5 py-4 text-left">No</th>
                            <th class="px-5 py-4 text-left">Kode Dosen</th>
                            <th class="px-5 py-4 text-left">Nama Dosen</th>
                            <th class="px-5 py-4 text-left">NIP</th>
                            <th class="px-5 py-4 text-left">Jabatan</th>
                            <th class="px-5 py-4 text-left">Status Prodi</th>
                            <th class="px-5 py-4 text-left">Pendidikan</th>
                            <th class="px-5 py-4 text-left">Jenis Kelamin</th>
                            <th class="px-5 py-4 text-left">Agama</th>
                            <th class="px-5 py-4 text-left">Tahun Lulus</th>
                            <th class="px-5 py-4 text-left">No. HP</th>
                            <th class="px-5 py-4 text-left">Status Aktivitas</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 text-slate-600">

                        <?php if (!empty($dosenList)): ?>

                            <?php foreach ($dosenList as $index => $row): ?>

                                <?php
                                    $id = $row['id_dosen'] ?? '';

                                    $status = $row['nama_status_aktivitas']
                                        ?? $row['status_aktivitas']
                                        ?? '-';
                                ?>

                                <tr>

                                    <td class="px-5 py-5 font-semibold text-slate-400">
                                        <?= $index + 1 ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <span class="font-bold text-blue-600">
                                            <?= esc($row['kode_dosen'] ?? '-') ?>
                                        </span>
                                    </td>

                                    <td class="px-5 py-5">
                                        <div class="font-semibold text-slate-800">
                                            <?= esc($row['nama'] ?? '-') ?>
                                        </div>
                                    </td>

                                    <td class="px-5 py-5 text-slate-500">
                                        <?= esc($row['nip'] ?? '-') ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <?= esc($row['nama_jabatan'] ?? $row['jabatan_fungsional'] ?? '-') ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <?= esc($row['nama_status_prodi'] ?? $row['status_prodi'] ?? '-') ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <?= esc($row['nama_pendidikan'] ?? $row['pendidikan_terakhir'] ?? '-') ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <?= esc($row['jenis_kelamin'] ?? '-') ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <?= esc($row['nama_agama'] ?? $row['agama'] ?? '-') ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <?= esc($row['tahun_lulus'] ?? '-') ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <?= esc($row['no_hp'] ?? '-') ?>
                                    </td>

                                    <td class="px-5 py-5">

                                        <?php if (strtolower($status) === 'aktif'): ?>

                                            <span class="inline-flex items-center gap-1.5
                                                         px-3 py-1.5 rounded-full
                                                         bg-green-100 text-green-700
                                                         text-xs font-bold">

                                                <span class="w-1.5 h-1.5
                                                             bg-green-500 rounded-full">
                                                </span>

                                                Aktif

                                            </span>

                                        <?php else: ?>

                                            <span class="inline-flex items-center
                                                         px-3 py-1.5 rounded-full
                                                         bg-orange-100 text-orange-700
                                                         text-xs font-bold">

                                                <?= esc($status) ?>

                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- AKSI -->
                                    <td class="px-5 py-5">

                                        <div class="flex items-center
                                                    justify-center gap-2">

                                            <a
                                                href="<?= site_url('dosen/' . $id) ?>"
                                                class="action-button px-3 py-2
                                                       rounded-lg border border-blue-200
                                                       text-blue-600 hover:bg-blue-600
                                                       hover:text-white text-xs font-semibold"
                                            >
                                                Detail
                                            </a>


                                            <a
                                                href="<?= site_url('dosen/edit/' . $id) ?>"
                                                class="action-button px-3 py-2
                                                       rounded-lg border border-amber-200
                                                       text-amber-600 hover:bg-amber-500
                                                       hover:text-white text-xs font-semibold"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                action="<?= site_url('dosen/delete/' . $id) ?>"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dosen ini?')"
                                            >

                                                <?= csrf_field() ?>

                                                <button
                                                    type="submit"
                                                    class="action-button px-3 py-2
                                                           rounded-lg border border-red-200
                                                           text-red-600 hover:bg-red-600
                                                           hover:text-white text-xs font-semibold"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="13" class="px-5 py-16 text-center">

                                    <div class="text-4xl mb-3">📂</div>

                                    <h4 class="font-bold text-slate-700">
                                        Data dosen belum tersedia
                                    </h4>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Silakan tambahkan data dosen terlebih dahulu.
                                    </p>

                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <!-- TABLE FOOTER -->
            <div class="px-6 py-4 border-t border-slate-100
                        bg-slate-50 flex flex-col sm:flex-row
                        justify-between gap-2">

                <p class="text-xs text-slate-500">
                    Menampilkan <?= $totalDosen ?> data dosen
                </p>

                <p class="text-xs text-slate-400">
                    TRPL Information System · Kelompok 4
                </p>

            </div>

        </section>


        <!-- FOOTER -->
        <footer class="mt-7 text-center text-xs text-slate-400">
            © <?= date('Y') ?> TRPL Information System. All rights reserved.
        </footer>

    </main>

</div>


<!-- JAVASCRIPT -->
<script>

    // Konfirmasi logout
    function confirmLogout(event) {

        event.preventDefault();

        const yakin = confirm(
            'Apakah kamu yakin ingin keluar dari akun Admin?'
        );

        if (yakin) {
            window.location.href = event.currentTarget.href;
        }

        return false;
    }

    // Animasi saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function () {

        const cards = document.querySelectorAll('.stat-card');

        cards.forEach(function (card, index) {
            card.style.animationDelay = (index * 0.12) + 's';
        });

    });

</script>

</body>
</html>
