
<?php
$isEdit = isset($dosen['id_dosen']);

$title = $isEdit ? 'Edit Data Dosen' : 'Tambah Data Dosen';

// Ambil nilai lama dari form, jika kosong gunakan nilai database
$jabatan = old('jabatan_fungsional')
    ?: ($dosen['nama_jabatan'] ?? $dosen['jabatan_fungsional'] ?? '');

$statusProdi = old('status_prodi')
    ?: ($dosen['nama_status_prodi'] ?? $dosen['status_prodi'] ?? '');

$statusAktivitas = old('status_aktivitas')
    ?: ($dosen['nama_status_aktivitas'] ?? $dosen['status_aktivitas'] ?? '');

$pendidikan = old('pendidikan_terakhir')
    ?: ($dosen['nama_pendidikan'] ?? $dosen['pendidikan_terakhir'] ?? '');

$agama = old('agama')
    ?: ($dosen['nama_agama'] ?? $dosen['agama'] ?? '');

$jenisKelamin = old('jenis_kelamin')
    ?: ($dosen['jenis_kelamin'] ?? '');

$jenisKelamin = strtoupper(trim($jenisKelamin));

if (in_array($jenisKelamin, ['L', 'LAKI-LAKI', 'LAKI LAKI'], true)) {
    $jenisKelamin = 'Laki-laki';
} elseif (in_array($jenisKelamin, ['P', 'PEREMPUAN'], true)) {
    $jenisKelamin = 'Perempuan';
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?> | Sistem Informasi Dosen</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background-color: #f8fafc;
            color: #1e293b;
            font-size: 14px;
            outline: none;
            transition: all .2s ease;
        }

        .form-input:focus {
            border-color: #3b82f6;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

        .required {
            color: #ef4444;
        }

        .section-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #eff6ff;
            color: #2563eb;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50">

    <div class="min-h-screen">

        <!-- Header -->
        <header class="bg-white border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-5 md:px-8 py-4 flex items-center justify-between">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
                        D
                    </div>

                    <div>
                        <h1 class="font-bold text-slate-800 text-sm md:text-base">
                            Sistem Informasi Dosen
                        </h1>
                        <p class="text-xs text-slate-500">
                            Manajemen Data Dosen
                        </p>
                    </div>
                </div>

                <a href="<?= base_url('dosen') ?>"
                   class="flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-blue-600 transition">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7"/>
                    </svg>

                    <span class="hidden sm:inline">Kembali ke Data Dosen</span>
                    <span class="sm:hidden">Kembali</span>
                </a>

            </div>
        </header>


        <!-- Main Content -->
        <main class="max-w-5xl mx-auto px-5 md:px-8 py-8 md:py-10">

            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
                <a href="<?= base_url('dashboard') ?>" class="hover:text-blue-600">
                    Dashboard
                </a>

                <span>/</span>

                <a href="<?= base_url('dosen') ?>" class="hover:text-blue-600">
                    Data Dosen
                </a>

                <span>/</span>

                <span class="text-blue-600 font-semibold">
                    <?= esc($title) ?>
                </span>
            </div>


            <!-- Page Heading -->
            <div class="mb-7">
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-semibold mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    FORMULIR DATA DOSEN
                </div>

                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">
                    <?= esc($title) ?>
                </h2>

                <p class="text-sm text-slate-500 mt-2 max-w-2xl leading-relaxed">
                    <?= $isEdit
                        ? 'Perbarui informasi dosen dengan mengisi formulir di bawah ini.'
                        : 'Lengkapi informasi dosen dengan benar untuk menambahkan data ke dalam sistem.' ?>
                </p>
            </div>


            <!-- Notification -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-5 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    <p class="font-bold mb-2">Terdapat kesalahan pada formulir:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>


            <!-- Form Card -->
            <form
                action="<?= $isEdit
                    ? base_url('dosen/update/' . $dosen['id_dosen'])
                    : base_url('dosen/simpan') ?>"
                method="POST"
            >

                <?= csrf_field() ?>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

                    <!-- Card Header -->
                    <div class="px-6 md:px-8 py-5 border-b border-slate-100 flex items-center justify-between">

                        <div>
                            <h3 class="font-bold text-slate-800">
                                Informasi Dosen
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">
                                Isi seluruh kolom yang bertanda bintang (*).
                            </p>
                        </div>

                        <div class="hidden sm:flex items-center gap-2 text-xs text-slate-400">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 11c0-1.1.9-2 2-2s2 .9 2 2v2h-4v-2z M5 11V7a7 7 0 0114 0v4 M5 11h14v10H5V11z"/>
                            </svg>
                            Data tersimpan secara aman
                        </div>

                    </div>


                    <div class="p-6 md:p-8 space-y-9">

                        <!-- SECTION 1 -->
                        <section>

                            <div class="flex items-center gap-3 mb-6">
                                <div class="section-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0z M4 21a8 8 0 0116 0"/>
                                    </svg>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">
                                        Identitas Dosen
                                    </h4>
                                    <p class="text-xs text-slate-400">
                                        Informasi identitas dan nomor kepegawaian
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="form-label">
                                        Kode Dosen <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="kode_dosen"
                                        value="<?= esc(old('kode_dosen', $dosen['kode_dosen'] ?? '')) ?>"
                                        placeholder="Contoh: D033"
                                        required
                                        class="form-input"
                                    >
                                </div>

                                <div>
                                    <label class="form-label">
                                        NIP <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="nip"
                                        value="<?= esc(old('nip', $dosen['nip'] ?? '')) ?>"
                                        placeholder="Masukkan NIP 18 digit"
                                        maxlength="18"
                                        required
                                        class="form-input"
                                    >
                                </div>

                                <div class="md:col-span-2">
                                    <label class="form-label">
                                        Nama Lengkap <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="nama"
                                        value="<?= esc(old('nama', $dosen['nama'] ?? '')) ?>"
                                        placeholder="Masukkan nama lengkap beserta gelar"
                                        required
                                        class="form-input"
                                    >
                                </div>

                            </div>
                        </section>


                        <div class="border-t border-slate-100"></div>


                        <!-- SECTION 2 -->
                        <section>

                            <div class="flex items-center gap-3 mb-6">
                                <div class="section-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.42A12.08 12.08 0 0118 16.5c0 1.38-2.69 2.5-6 2.5s-6-1.12-6-2.5c0-2.2.59-4.24 1.84-5.92L12 14z"/>
                                    </svg>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">
                                        Informasi Akademik dan Kepegawaian
                                    </h4>
                                    <p class="text-xs text-slate-400">
                                        Jabatan, status, dan riwayat pendidikan
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="form-label">
                                        Jabatan Fungsional <span class="required">*</span>
                                    </label>

                                    <select name="jabatan_fungsional" required class="form-input">
                                        <option value="">Pilih Jabatan</option>

                                        <?php foreach (['Asisten Ahli', 'Lektor', 'Lektor Kepala'] as $item): ?>
                                            <option value="<?= esc($item) ?>"
                                                <?= old('jabatan_fungsional', $jabatan) === $item ? 'selected' : '' ?>>
                                                <?= esc($item) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">
                                        Status Prodi <span class="required">*</span>
                                    </label>

                                    <select name="status_prodi" required class="form-input">
                                        <option value="">Pilih Status Prodi</option>

                                        <?php foreach (['Dosen Tetap', 'Tidak Tetap'] as $item): ?>
                                            <option value="<?= esc($item) ?>"
                                                <?= old('status_prodi', $statusProdi) === $item ? 'selected' : '' ?>>
                                                <?= esc($item) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                              
<div>
    <label class="form-label">
        Status Aktivitas <span class="required">*</span>
    </label>

    <select name="status_aktivitas" required class="form-input">
        <option value="">Pilih Status Aktivitas</option>

        <?php foreach (['Aktif', 'Tidak Aktif'] as $item): ?>
            <option value="<?= esc($item) ?>"
                <?= $statusAktivitas === $item ? 'selected' : '' ?>>
                <?= esc($item) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
    <div>
                                    <label class="form-label">
                                        Pendidikan Terakhir <span class="required">*</span>
                                    </label>

                                    <select name="pendidikan_terakhir" required class="form-input">
                                        <option value="">Pilih Pendidikan</option>

                                        <?php foreach (['S2', 'S3'] as $item): ?>
                                            <option value="<?= esc($item) ?>"
                                                <?= old('pendidikan_terakhir', $pendidikan) === $item ? 'selected' : '' ?>>
                                                <?= esc($item) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">
                                        Tahun Lulus
                                    </label>

                                    <input
                                        type="number"
                                        name="tahun_lulus"
                                        value="<?= esc(old('tahun_lulus', $dosen['tahun_lulus'] ?? '')) ?>"
                                        placeholder="Contoh: 2015"
                                        min="1900"
                                        max="2100"
                                        class="form-input"
                                    >
                                </div>

                            </div>
                        </section>


                        <div class="border-t border-slate-100"></div>


                        <!-- SECTION 3 -->
                        <section>

                            <div class="flex items-center gap-3 mb-6">
                                <div class="section-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2 M10 11a4 4 0 100-8 4 4 0 000 8z M20 8v6 M23 11h-6"/>
                                    </svg>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">
                                        Informasi Pribadi
                                    </h4>
                                    <p class="text-xs text-slate-400">
                                        Informasi tambahan dosen
                                    </p>
                                </div>
                            </div>

                          
<div>
    <label class="form-label">
        Jenis Kelamin <span class="required">*</span>
    </label>

    <select name="jenis_kelamin" required class="form-input">
        <option value="">Pilih Jenis Kelamin</option>

        <option value="Laki-laki"
            <?= $jenisKelamin === 'Laki-laki' ? 'selected' : '' ?>>
            Laki-laki
        </option>

        <option value="Perempuan"
            <?= $jenisKelamin === 'Perempuan' ? 'selected' : '' ?>>
            Perempuan
        </option>
    </select>
</div>

                                <div>
                                    <label class="form-label">
                                        Agama <span class="required">*</span>
                                    </label>

                                    <select name="agama" required class="form-input">
                                        <option value="">Pilih Agama</option>

                                        <?php foreach (['Islam', 'Kristen'] as $item): ?>
                                            <option value="<?= esc($item) ?>"
                                                <?= old('agama', $agama) === $item ? 'selected' : '' ?>>
                                                <?= esc($item) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="form-label">
                                        Nomor HP
                                    </label>

                                    <input
                                        type="text"
                                        name="no_hp"
                                        value="<?= esc(old('no_hp', $dosen['no_hp'] ?? '')) ?>"
                                        placeholder="Contoh: 081234567890"
                                        class="form-input"
                                    >
                                </div>

                            </div>
                        </section>

                    </div>


                    <!-- Footer Form -->
                    <div class="px-6 md:px-8 py-5 bg-slate-50 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4">

                        <p class="text-xs text-slate-400">
                            <span class="required">*</span> Wajib diisi
                        </p>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a
                                href="<?= base_url('dosen') ?>"
                                class="px-5 py-3 rounded-xl border border-slate-300 text-slate-600 text-sm font-semibold text-center hover:bg-slate-100 transition"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow-lg shadow-blue-600/20 transition flex items-center justify-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>

                                <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Data Dosen' ?>
                            </button>

                        </div>

                    </div>

                </div>

            </form>


            <!-- Bottom Note -->
            <div class="mt-5 flex items-start gap-2 text-xs text-slate-400">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 110-20 10 10 0 010 20z"/>
                </svg>

                <p>
                    Pastikan informasi yang dimasukkan sudah benar sebelum menyimpan data ke dalam sistem.
                </p>
            </div>

        </main>

    </div>

</body>
</html>
