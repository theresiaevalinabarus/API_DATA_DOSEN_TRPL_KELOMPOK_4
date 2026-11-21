
<?php
$dosenList = $dosen ?? [];
$totalDosen = count($dosenList);

$aktif = count(array_filter($dosenList, function ($item) {
    $status = $item['nama_status_aktivitas']
        ?? $item['status_aktivitas']
        ?? '';

    return strtolower(trim($status)) === 'aktif';
}));

$keyword = $keyword ?? '';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Direktori Dosen | TRPL Polmed</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f8fc;
        }

        .hero-bg {
            background:
                radial-gradient(circle at 85% 20%, rgba(96, 165, 250, .28), transparent 28%),
                linear-gradient(120deg, #0b1e3b, #173e75 60%, #2563a8);
        }

        .glass {
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .18);
            backdrop-filter: blur(12px);
        }

        .table-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
        }

        .table-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .table-scroll {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .stat-card {
            transition: all .25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(15, 45, 85, .08);
        }

        .table-row {
            transition: background .2s ease;
        }

        .table-row:hover {
            background: #f5f9ff;
        }
    </style>
</head>

<body class="text-slate-800">

<!-- ================= NAVBAR ================= -->

<nav class="bg-white/95 backdrop-blur border-b border-slate-100 sticky top-0 z-50">

    <div class="max-w-[1450px] mx-auto px-5 md:px-8">

        <div class="h-20 flex items-center justify-between gap-4">

            <a href="<?= site_url('/') ?>" class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-2xl bg-[#102F52] text-white
                            flex items-center justify-center text-xl font-extrabold shadow-lg">
                    T
                </div>

                <div>
                    <h1 class="font-extrabold text-lg text-[#102F52] tracking-tight">
                        TRPL POLMED
                    </h1>

                    <p class="text-xs text-slate-500">
                        Data Dosen & Informasi Prodi
                    </p>
                </div>

            </a>

            <div class="flex items-center gap-5">

                <a href="<?= site_url('/') ?>"
                   class="hidden sm:block text-sm font-semibold text-slate-600 hover:text-blue-600 transition">
                    Beranda
                </a>

                <a href="<?= site_url('login') ?>"
                   class="px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                          text-white text-sm font-bold shadow-lg shadow-blue-600/20 transition">
                    Login Admin ↗
                </a>

            </div>

        </div>

    </div>

</nav>

<!-- ================= HERO ================= -->

<section class="hero-bg text-white overflow-hidden">

    <div class="max-w-[1450px] mx-auto px-5 md:px-8 py-16 md:py-20">

        <div class="grid md:grid-cols-2 gap-12 items-center">

            <div>

                <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 mb-6">

                    <span class="w-2 h-2 rounded-full bg-green-400"></span>

                    <span class="text-xs font-semibold tracking-wide text-blue-100">
                        SISTEM INFORMASI DATA DOSEN
                    </span>

                </div>

                <h2 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">

                    Kenali Tenaga Pendidik

                    <span class="text-blue-300">
                        TRPL Polmed
                    </span>

                </h2>

                <p class="mt-6 text-blue-100 leading-8 text-sm md:text-base max-w-xl">

                    Temukan informasi tenaga pendidik Program Studi
                    Teknologi Rekayasa Perangkat Lunak Politeknik Negeri Medan
                    melalui direktori data dosen.

                </p>

                <div class="flex flex-wrap gap-3 mt-8">

                    <a href="#daftar-dosen"
                       class="px-6 py-3.5 rounded-xl bg-white text-[#102F52]
                              font-bold text-sm hover:bg-blue-50 transition shadow-lg">
                        Jelajahi Data Dosen ↓
                    </a>

                    <a href="<?= site_url('/') ?>"
                       class="px-6 py-3.5 rounded-xl glass text-white
                              font-semibold text-sm hover:bg-white/20 transition">
                        Kembali ke Beranda
                    </a>

                </div>

            </div>

            <div class="hidden md:flex justify-center">

                <div class="relative w-80 h-72">

                    <div class="absolute inset-5 rounded-[2rem]
                                bg-white/10 border border-white/20 rotate-6">
                    </div>

                    <div class="absolute inset-5 rounded-[2rem] glass
                                flex flex-col items-center justify-center shadow-2xl">

                        <div class="w-24 h-24 rounded-3xl bg-white/15
                                    flex items-center justify-center text-5xl mb-5">
                            🎓
                        </div>

                        <p class="text-2xl font-extrabold">
                            TRPL POLMED
                        </p>

                        <p class="text-blue-200 text-sm mt-2">
                            Direktori Tenaga Pendidik
                        </p>

                        <div class="flex gap-2 mt-6">

                            <span class="w-2 h-2 rounded-full bg-blue-300"></span>
                            <span class="w-2 h-2 rounded-full bg-white/50"></span>
                            <span class="w-2 h-2 rounded-full bg-white/50"></span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= MAIN ================= -->

<main class="max-w-[1450px] mx-auto px-5 md:px-8 py-12">

    <!-- ================= STATISTIK ================= -->

    <section class="grid sm:grid-cols-2 gap-5 mb-12">

        <div class="stat-card bg-white border border-slate-200
                    rounded-2xl p-6 shadow-sm flex items-center gap-5">

            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600
                        flex items-center justify-center text-2xl">
                👨‍🏫
            </div>

            <div>

                <p class="text-sm text-slate-500 font-medium">
                    Total Data Dosen
                </p>

                <h3 class="text-3xl font-extrabold text-[#102F52] mt-1">
                    <?= $totalDosen ?>
                </h3>

                <p class="text-xs text-slate-400 mt-1">
                    Tenaga pendidik terdaftar
                </p>

            </div>

        </div>

        <div class="stat-card bg-white border border-slate-200
                    rounded-2xl p-6 shadow-sm flex items-center gap-5">

            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600
                        flex items-center justify-center text-2xl">
                ✓
            </div>

            <div>

                <p class="text-sm text-slate-500 font-medium">
                    Dosen Aktif
                </p>

                <h3 class="text-3xl font-extrabold text-green-600 mt-1">
                    <?= $aktif ?>
                </h3>

                <p class="text-xs text-slate-400 mt-1">
                    Status aktivitas aktif
                </p>

            </div>

        </div>

    </section>

    <!-- ================= DIREKTORI ================= -->

    <section id="daftar-dosen" class="scroll-mt-24">

        <div class="flex flex-col md:flex-row md:items-end
                    md:justify-between gap-4 mb-6">

            <div>

                <p class="text-blue-600 text-xs font-bold tracking-widest mb-2">
                    DIREKTORI AKADEMIK
                </p>

                <h2 class="text-2xl md:text-3xl font-extrabold text-[#102F52]">
                    Daftar Tenaga Pendidik
                </h2>

                <p class="text-sm text-slate-500 mt-2">
                    Informasi dosen Program Studi TRPL Politeknik Negeri Medan.
                </p>

            </div>

            <div class="text-sm text-slate-500">

                <span class="font-bold text-[#102F52]">
                    <?= $totalDosen ?>
                </span>

                data tersedia

            </div>

        </div>

        <!-- ================= SEARCH CARD ================= -->

        <div class="bg-white rounded-2xl border border-slate-200
                    shadow-sm overflow-hidden">

            <div class="p-5 md:p-6 border-b border-slate-100">

                <form action="<?= site_url('direktori-dosen') ?>"
                      method="GET"
                      class="flex flex-col sm:flex-row gap-3">

                    <div class="relative flex-1">

                        <span class="absolute left-4 top-1/2
                                     -translate-y-1/2 text-slate-400">
                            🔎
                        </span>

                        <input
                            type="text"
                            name="keyword"
                            value="<?= esc($keyword) ?>"
                            placeholder="Cari nama, NIP, atau kode dosen..."
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl
                                   border border-slate-200 bg-slate-50
                                   text-sm outline-none focus:bg-white
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500 transition"
                        >

                    </div>

                    <button
                        type="submit"
                        class="px-7 py-3.5 rounded-xl bg-blue-600
                               hover:bg-blue-700 text-white text-sm
                               font-bold transition shadow-md shadow-blue-600/20">
                        Cari Dosen
                    </button>

                    <?php if ($keyword !== ''): ?>

                        <a href="<?= site_url('direktori-dosen') ?>"
                           class="px-5 py-3.5 rounded-xl bg-slate-100
                                  hover:bg-slate-200 text-slate-600
                                  text-sm font-semibold text-center transition">
                            Reset
                        </a>

                    <?php endif; ?>

                </form>

            </div>

            <!-- ================= TABLE ================= -->

            <div class="table-scroll overflow-x-auto">

                <table class="w-full text-sm min-w-[1450px]">

                    <thead class="bg-slate-50 text-slate-500
                                  text-xs uppercase tracking-wider">

                        <tr>

                            <th class="px-5 py-5 text-left">No.</th>

                            <th class="px-5 py-5 text-left">Kode Dosen</th>

                            <th class="px-5 py-5 text-left">NIP</th>

                            <th class="px-5 py-5 text-left">Nama Dosen</th>

                            <th class="px-5 py-5 text-left">Jabatan</th>

                            <th class="px-5 py-5 text-left">Status Prodi</th>

                            <th class="px-5 py-5 text-left">Pendidikan</th>

                            <th class="px-5 py-5 text-left">Jenis Kelamin</th>

                            <th class="px-5 py-5 text-left">Agama</th>

                            <th class="px-5 py-5 text-left">Tahun Lulus</th>

                            <th class="px-5 py-5 text-left">Aktivitas</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($dosenList)): ?>

                        <?php foreach ($dosenList as $index => $row): ?>

                            <?php

                            $status = $row['nama_status_aktivitas']
                                ?? $row['status_aktivitas']
                                ?? '-';

                            $jabatan = $row['nama_jabatan']
                                ?? $row['jabatan_fungsional']
                                ?? '-';

                            $statusProdi = $row['nama_status_prodi']
                                ?? $row['status_prodi']
                                ?? '-';

                            $pendidikan = $row['nama_pendidikan']
                                ?? $row['pendidikan_terakhir']
                                ?? '-';

                            $agama = $row['nama_agama']
                                ?? $row['agama']
                                ?? '-';

                            $isAktif = strtolower(trim($status)) === 'aktif';

                            ?>

                            <tr class="table-row">

                                <!-- NOMOR -->

                                <td class="px-5 py-5 text-slate-400 font-semibold">
                                    <?= $index + 1 ?>
                                </td>

                                <!-- KODE DOSEN -->

                                <td class="px-5 py-5">

                                    <span class="inline-flex px-3 py-1.5
                                                 rounded-lg bg-blue-50
                                                 text-blue-700 font-bold text-xs">
                                        <?= esc($row['kode_dosen'] ?? '-') ?>
                                    </span>

                                </td>

                                <!-- NIP -->

                                <td class="px-5 py-5 text-slate-600 font-medium">
                                    <?= esc($row['nip'] ?? '-') ?>
                                </td>

                                <!-- NAMA -->

                                <td class="px-5 py-5">

                                    <p class="font-bold text-slate-800">
                                        <?= esc($row['nama'] ?? '-') ?>
                                    </p>

                                    <p class="text-xs text-slate-400 mt-1">
                                        Dosen TRPL
                                    </p>

                                </td>

                                <!-- JABATAN -->

                                <td class="px-5 py-5 text-slate-600">
                                    <?= esc($jabatan) ?>
                                </td>

                                <!-- STATUS PRODI -->

                                <td class="px-5 py-5 text-slate-600">
                                    <?= esc($statusProdi) ?>
                                </td>

                                <!-- PENDIDIKAN -->

                                <td class="px-5 py-5 text-slate-600">
                                    <?= esc($pendidikan) ?>
                                </td>

                                <!-- JENIS KELAMIN -->

                                <td class="px-5 py-5 text-slate-600">
                                    <?= esc($row['jenis_kelamin'] ?? '-') ?>
                                </td>

                                <!-- AGAMA -->

                                <td class="px-5 py-5 text-slate-600">
                                    <?= esc($agama) ?>
                                </td>

                                <!-- TAHUN LULUS -->

                                <td class="px-5 py-5 text-slate-600">
                                    <?= esc($row['tahun_lulus'] ?? '-') ?>
                                </td>

                                <!-- AKTIVITAS -->

                                <td class="px-5 py-5">

                                    <?php if ($isAktif): ?>

                                        <span class="inline-flex items-center gap-2
                                                     px-3 py-1.5 rounded-full
                                                     bg-green-50 text-green-700
                                                     text-xs font-bold">

                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                            Aktif

                                        </span>

                                    <?php else: ?>

                                        <span class="inline-flex items-center gap-2
                                                     px-3 py-1.5 rounded-full
                                                     bg-orange-50 text-orange-700
                                                     text-xs font-bold">

                                            <span class="w-2 h-2 rounded-full bg-orange-500"></span>

                                            <?= esc($status) ?>

                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="11" class="px-6 py-20 text-center">

                                <div class="text-5xl mb-4">
                                    🔍
                                </div>

                                <h3 class="font-bold text-slate-700 text-lg">
                                    Data dosen tidak ditemukan
                                </h3>

                                <p class="text-sm text-slate-400 mt-2">
                                    Silakan periksa kembali kata kunci pencarian.
                                </p>

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- ================= FOOTER TABLE ================= -->

            <div class="px-6 py-5 bg-slate-50 border-t border-slate-100
                        flex flex-col sm:flex-row justify-between gap-2">

                <p class="text-xs text-slate-500">
                    Menampilkan <?= $totalDosen ?> data dosen
                </p>

                <p class="text-xs text-slate-400">
                    TRPL Information System · Kelompok 4
                </p>

            </div>

        </div>

    </section>

    <!-- ================= CTA ================= -->

    <section class="mt-12 rounded-3xl bg-[#102F52]
                    p-8 md:p-10 text-white
                    flex flex-col md:flex-row
                    md:items-center md:justify-between gap-6">

        <div>

            <h3 class="text-xl md:text-2xl font-extrabold">
                Pengelolaan Data Dosen
            </h3>

            <p class="text-sm text-blue-200 mt-2 leading-6">
                Akses administrator hanya diperuntukkan bagi pengelola sistem.
            </p>

        </div>

        <a href="<?= site_url('login') ?>"
           class="inline-flex items-center justify-center px-6 py-3.5
                  rounded-xl bg-white text-[#102F52] text-sm
                  font-bold hover:bg-blue-50 transition">
            Login sebagai Admin ↗
        </a>

    </section>

</main>

<!-- ================= FOOTER ================= -->

<footer class="bg-[#09172D] text-white mt-16">

    <div class="max-w-[1450px] mx-auto px-5 md:px-8 py-9">

        <div class="flex flex-col md:flex-row justify-between gap-6">

            <div>

                <h3 class="font-extrabold text-lg">
                    TRPL POLMED
                </h3>

                <p class="text-sm text-blue-200 mt-2 max-w-md leading-6">

                    Sistem Informasi Data Dosen Program Studi
                    Teknologi Rekayasa Perangkat Lunak,
                    Politeknik Negeri Medan.

                </p>

            </div>

            <div>

                <p class="font-bold text-sm mb-3">
                    Navigasi
                </p>

                <a href="<?= site_url('/') ?>"
                   class="block text-sm text-blue-200 hover:text-white transition">
                    Beranda
                </a>

                <a href="<?= site_url('login') ?>"
                   class="block text-sm text-blue-200 hover:text-white mt-2 transition">
                    Login Admin
                </a>

            </div>

        </div>

        <div class="border-t border-slate-700 mt-8 pt-6 text-center">

            <p class="text-xs text-blue-200">

                © <?= date('Y') ?> Sistem Informasi Data Dosen TRPL Polmed.
                Dikembangkan oleh Kelompok 4.

            </p>

        </div>

    </div>

</footer>

</body>
</html>