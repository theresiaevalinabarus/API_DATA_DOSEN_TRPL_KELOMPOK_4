<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .welcome {
        background: linear-gradient(115deg, #173f7a, #4385f5);
        border-radius: 18px;
        padding: 30px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px #2563eb20;
    }

    .welcome h2 {
        font-size: 23px;
        margin-bottom: 10px;
    }

    .welcome p {
        font-size: 13px;
        color: #e0ecff;
        line-height: 1.8;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        padding: 23px;
        border-radius: 16px;
        border: 1px solid #edf1f7;
        box-shadow: 0 4px 18px #1e293b08;
        transition: .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px #1e293b12;
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        display: grid;
        place-items: center;
        border-radius: 13px;
        font-size: 21px;
        margin-bottom: 17px;
    }

    .blue { background: #eaf2ff; }
    .green { background: #e6f8ef; }
    .orange { background: #fff3e6; }

    .stat-card p {
        color: #8492a6;
        font-size: 12px;
    }

    .stat-card h2 {
        font-size: 29px;
        margin-top: 8px;
        color: #172f50;
    }

    .section-card {
        background: white;
        padding: 25px;
        border-radius: 16px;
        border: 1px solid #edf1f7;
        box-shadow: 0 4px 18px #1e293b08;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .section-header h2 {
        font-size: 18px;
        color: #172f50;
    }

    .section-header p {
        font-size: 12px;
        color: #8492a6;
        margin-top: 7px;
    }

    /* KOLOM PENCARIAN */
    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #dce5f0;
        border-radius: 11px;
        padding: 0 14px;
        width: 320px;
        transition: .2s;
    }

    .search-box:focus-within {
        border-color: #3478f6;
        box-shadow: 0 0 0 3px #3478f61a;
        background: white;
    }

    .search-box span {
        font-size: 17px;
        color: #64748b;
    }

    .search-box input {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        padding: 13px 0;
        font-size: 12px;
        color: #172f50;
    }

    .search-box input::placeholder {
        color: #94a3b8;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    th {
        text-align: left;
        color: #8492a6;
        font-size: 11px;
        font-weight: 700;
        padding: 15px 12px;
        background: #f8fafc;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    td {
        padding: 16px 12px;
        border-bottom: 1px solid #edf1f6;
        font-size: 12px;
        color: #475569;
        vertical-align: middle;
    }

    tbody tr:hover {
        background: #f8fbff;
    }

    .id-label {
        color: #475569;
        font-weight: 700;
    }

    .kode-label {
        color: #2563eb;
        font-weight: 700;
        background: #eff6ff;
        padding: 6px 10px;
        border-radius: 7px;
        display: inline-block;
    }

    .detail-btn {
        display: inline-block;
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        padding: 7px 11px;
        background: #eff6ff;
        border-radius: 7px;
        transition: .2s;
        white-space: nowrap;
    }

    .detail-btn:hover {
        background: #dbeafe;
    }

    .empty {
        text-align: center;
        color: #94a3b8;
        padding: 30px;
    }

    .table-info {
        color: #94a3b8;
        font-size: 11px;
        margin-top: 16px;
    }

    @media(max-width: 850px) {
        .stats {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 550px) {
        .section-header {
            align-items: stretch;
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }

        .welcome {
            padding: 23px;
        }

        .section-card {
            padding: 17px;
        }
    }
</style>

<!-- WELCOME -->
<section class="welcome">
    <h2>Selamat Datang! 👋</h2>
    <p>
        Selamat datang di Sistem Informasi Data Dosen TRPL.
        Kelola dan pantau informasi dosen dengan lebih mudah,
        cepat, dan terorganisir.
    </p>
</section>

<!-- STATISTIK -->
<section class="stats">

    <div class="stat-card">
        <div class="stat-icon blue">👨‍🏫</div>
        <p>Total Data Dosen</p>
        <h2><?= esc($totalDosen ?? 0) ?></h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">✓</div>
        <p>Dosen Aktif</p>
        <h2><?= esc($totalAktif ?? 0) ?></h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">◷</div>
        <p>Dosen Tidak Aktif</p>
        <h2><?= esc($totalTidakAktif ?? 0) ?></h2>
    </div>

</section>

<!-- TABEL DATA DOSEN -->
<section class="section-card">

    <div class="section-header">
        <div>
            <h2>Daftar Data Dosen</h2>
            <p>Informasi dosen yang tersimpan dalam sistem.</p>
        </div>

        <!-- KOLOM PENCARIAN -->
        <div class="search-box">
            <span>⌕</span>
            <input
                type="text"
                id="searchDosen"
                placeholder="Cari ID, kode, nama, atau NIP..."
                autocomplete="off"
            >
        </div>
    </div>

    <div class="table-wrap">
        <table id="tabelDosen">

            <thead>
                <tr>
                    <th>NO.</th>
                    <th>ID DOSEN</th>
                    <th>KODE DOSEN</th>
                    <th>NAMA DOSEN</th>
                    <th>NIP</th>
                    <th>AKSI</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($dosen)): ?>

                    <?php foreach ($dosen as $i => $item): ?>

                        <tr>
                            <!-- NOMOR -->
                            <td><?= $i + 1 ?></td>

                            <!-- ID DOSEN INT -->
                            <td>
                                <span class="id-label">
                                    <?= esc($item['id_dosen'] ?? '-') ?>
                                </span>
                            </td>

                            <!-- KODE DOSEN VARCHAR -->
                            <td>
                                <span class="kode-label">
                                    <?= esc($item['kode_dosen'] ?? '-') ?>
                                </span>
                            </td>

                            <!-- NAMA DOSEN -->
                            <td>
                                <?= esc($item['nama'] ?? '-') ?>
                            </td>

                            <!-- NIP -->
                            <td>
                                <?= esc($item['nip'] ?? '-') ?>
                            </td>

                            <!-- AKSI -->
                            <td>
                                <a
                                    class="detail-btn"
                                    href="<?= site_url('dosen/' . rawurlencode((string) ($item['id_dosen'] ?? ''))) ?>"
                                >
                                    Lihat detail →
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="empty">
                            Belum ada data dosen.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>
    </div>

    <p class="table-info" id="jumlahTampil">
        Menampilkan <?= count($dosen ?? []) ?> data dosen.
    </p>

</section>

<!-- JAVASCRIPT PENCARIAN -->
<script>
    const searchInput = document.getElementById('searchDosen');
    const tableBody = document.querySelector('#tabelDosen tbody');
    const rows = tableBody.querySelectorAll('tr');
    const jumlahTampil = document.getElementById('jumlahTampil');

    const jumlahAwal = <?= (int) count($dosen ?? []) ?>;

    searchInput.addEventListener('input', function () {

        const keyword = this.value.toLowerCase().trim();
        let jumlah = 0;

        rows.forEach(function (row) {

            // Lewati baris pesan jika data kosong
            if (row.cells.length < 6) {
                return;
            }

            const id = row.cells[1].textContent.toLowerCase();
            const kode = row.cells[2].textContent.toLowerCase();
            const nama = row.cells[3].textContent.toLowerCase();
            const nip = row.cells[4].textContent.toLowerCase();

            const cocok =
                id.includes(keyword) ||
                kode.includes(keyword) ||
                nama.includes(keyword) ||
                nip.includes(keyword);

            row.style.display = cocok ? '' : 'none';

            if (cocok) {
                jumlah++;
            }

        });

        jumlahTampil.textContent =
            'Menampilkan ' + jumlah + ' dari ' +
            jumlahAwal + ' data dosen.';

    });
</script>

<?= $this->endSection() ?>
