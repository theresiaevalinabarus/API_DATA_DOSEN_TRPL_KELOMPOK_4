<?php
$dosenList = $dosen ?? [];
$totalDosen = count($dosenList);
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
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 255px;
            min-width: 255px;
        }

        .main-content {
            min-width: 0;
        }

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

        .data-table th {
            white-space: nowrap;
        }

        .data-table td {
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 75px;
                min-width: 75px;
            }

            .sidebar-text {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="sidebar bg-[#102F52] text-white flex flex-col justify-between
              sticky top-0 h-screen self-start flex-shrink-0 overflow-y-auto">

        <div>

            <!-- Logo -->
            <div class="px-5 py-8">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-blue-500 flex items-center justify-center text-xl shadow-lg">
                        🎓
                    </div>

                    <div class="sidebar-text">
                        <h1 class="font-extrabold text-lg">Data Dosen</h1>
                        <p class="text-blue-200 text-xs">TRPL Information System</p>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <div class="px-4">

                <p class="sidebar-text text-[11px] font-bold tracking-widest text-blue-300 mb-4 px-3">
                    MENU UTAMA
                </p>

                <a href="<?= base_url('dashboard') ?>"
                   class="flex items-center gap-3 px-4 py-4 rounded-xl text-blue-100 hover:bg-blue-800 transition mb-2">

                    <span class="text-lg">📊</span>
                    <span class="sidebar-text text-sm font-semibold">Dashboard</span>
                </a>

                <a href="<?= base_url('dosen') ?>"
                   class="flex items-center gap-3 px-4 py-4 rounded-xl bg-blue-600 text-white shadow-lg mb-2">

                    <span class="text-lg">👨‍🏫</span>
                    <span class="sidebar-text text-sm font-semibold">Data Dosen</span>
                </a>

            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="px-6 py-7 border-t border-blue-900 sidebar-text">
            <p class="font-bold text-xs">Kelompok 4</p>
            <p class="text-blue-200 text-xs mt-2 leading-5">
                Teknologi Rekayasa<br>
                Perangkat Lunak
            </p>
        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main-content flex-1 p-5 md:p-8">

        <!-- TOP HEADER -->
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>
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

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                    K4
                </div>

                <div>
                    <p class="text-sm font-bold text-slate-700">Kelompok 4</p>
                    <p class="text-xs text-slate-400">Administrator</p>
                </div>
            </div>

        </header>


        <!-- FLASH MESSAGE -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>


        <!-- SUMMARY CARD -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-7">

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
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

                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">
                        👨‍🏫
                    </div>

                </div>
            </div>


            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500 font-medium">
                            Dosen Aktif
                        </p>

                        <h3 class="text-3xl font-extrabold text-green-600 mt-2">
                            <?php
                            $aktif = count(array_filter($dosenList, function ($item) {
                                return strtolower($item['nama_status_aktivitas'] ?? $item['status_aktivitas'] ?? '') === 'aktif';
                            }));
                            echo $aktif;
                            ?>
                        </h3>

                        <p class="text-xs text-slate-400 mt-2">
                            Status aktivitas aktif
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-2xl">
                        ✓
                    </div>

                </div>
            </div>


            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
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

                    <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl">
                        ◷
                    </div>

                </div>
            </div>

        </div>


        <!-- TABLE CARD -->
        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <!-- Table Heading -->
            <div class="p-6 border-b border-slate-100">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <div>
                        <h3 class="text-lg font-bold text-slate-800">
                            Daftar Dosen
                        </h3>

                        <p class="text-sm text-slate-400 mt-1">
                            Total hasil: <?= $totalDosen ?> dosen
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">

                        <!-- Search -->
                        <form action="<?= base_url('dosen') ?>" method="GET" class="flex gap-2">

                            <input
                                type="text"
                                name="keyword"
                                value="<?= esc($keyword ?? '') ?>"
                                placeholder="Cari nama, NIP, kode..."
                                class="w-full sm:w-64 px-4 py-2.5 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500"
                            >

                            <button
                                type="submit"
                                class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-sm font-semibold text-slate-700"
                            >
                                Cari
                            </button>

                        </form>

                        <!-- Add Button -->
                        <a
                            href="<?= base_url('dosen/tambah') ?>"
                            class="flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-600/20 transition"
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

                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">

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
                                $status = $row['nama_status_aktivitas'] ?? $row['status_aktivitas'] ?? '-';
                                ?>

                                <tr class="hover:bg-blue-50/50 transition">

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
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                                Aktif
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                                <?= esc($status) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-5 py-5">
                                        <div class="flex items-center justify-center gap-2">

                                            <a
                                                href="<?= base_url('dosen/' . $id) ?>"
                                                class="px-3 py-2 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white text-xs font-semibold transition"
                                            >
                                                Detail
                                            </a>

                                            <a
                                                href="<?= base_url('dosen/edit/' . $id) ?>"
                                                class="px-3 py-2 rounded-lg border border-amber-200 text-amber-600 hover:bg-amber-500 hover:text-white text-xs font-semibold transition"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="<?= base_url('dosen/hapus/' . $id) ?>"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dosen ini?')"
                                            >
                                                <?= csrf_field() ?>

                                                <button
                                                    type="submit"
                                                    class="px-3 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-600 hover:text-white text-xs font-semibold transition"
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


            <!-- Table Footer -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex flex-col sm:flex-row justify-between gap-2">

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

</body>
</html>
