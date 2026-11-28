
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .integrasi-page {
        padding: 8px 4px 30px;
        color: #172b4d;
    }

    .integrasi-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .integrasi-header h2 {
        font-size: 25px;
        font-weight: 750;
        color: #142d50;
        margin: 0 0 7px;
    }

    .integrasi-header p {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    .header-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #eaf4ff;
        color: #2671bd;
        padding: 8px 13px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
    }

    .integrasi-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 23px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e8eef6;
        border-radius: 15px;
        padding: 19px;
        box-shadow: 0 4px 15px rgba(30, 64, 105, .045);
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .stat-icon {
        width: 47px;
        height: 47px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .stat-blue { background: #e8f2ff; color: #347dcc; }
    .stat-green { background: #e7f8ef; color: #21965a; }
    .stat-orange { background: #fff3e4; color: #dc8b2d; }
    .stat-purple { background: #f1ebff; color: #8061c8; }

    .stat-card small {
        display: block;
        color: #8290a4;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .stat-card strong {
        display: block;
        font-size: 23px;
        font-weight: 750;
        color: #203957;
        line-height: 1.1;
    }

    .panel {
        background: #fff;
        border: 1px solid #e8eef6;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(30, 64, 105, .04);
    }

    .panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 17px;
    }

    .panel-heading h5 {
        color: #1d3656;
        font-size: 16px;
        font-weight: 750;
        margin: 0 0 5px;
    }

    .panel-heading p {
        color: #8996a8;
        font-size: 12px;
        margin: 0;
    }

    .api-status-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 11px;
    }

    .api-status {
        border: 1px solid #e9eef5;
        background: #fbfdff;
        border-radius: 12px;
        padding: 13px;
    }

    .api-status .api-name {
        display: block;
        font-size: 12px;
        color: #63748b;
        margin-bottom: 9px;
        font-weight: 600;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 9px;
        border-radius: 30px;
    }

    .status-online {
        background: #e5f8ed;
        color: #198754;
    }

    .status-offline {
        background: #fff0f0;
        color: #d34545;
    }

    .search-area {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 17px;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 230px;
    }

    .search-box input {
        width: 100%;
        height: 45px;
        border: 1px solid #dce6f1;
        border-radius: 11px;
        padding: 0 15px 0 42px;
        outline: none;
        font-size: 13px;
        color: #243b57;
        background: #fbfdff;
        transition: .2s;
    }

    .search-box input:focus {
        border-color: #6aa9e9;
        box-shadow: 0 0 0 3px rgba(72, 145, 220, .12);
        background: #fff;
    }

    .search-symbol {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #8b9db2;
        font-size: 16px;
    }

    .result-count {
        font-size: 12px;
        color: #8190a4;
        white-space: nowrap;
    }

    .lecturer-card {
        border: 1px solid #e8eef5;
        border-radius: 13px;
        margin-bottom: 13px;
        overflow: hidden;
        background: #fff;
        transition: .2s;
    }

    .lecturer-card:hover {
        border-color: #c8def5;
        box-shadow: 0 5px 16px rgba(42, 104, 169, .07);
    }

    .lecturer-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 17px;
        background: #fbfdff;
        flex-wrap: wrap;
    }

    .lecturer-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .lecturer-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #e8f2ff;
        color: #347dcc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        flex-shrink: 0;
    }

    .lecturer-info h6 {
        margin: 0 0 4px;
        color: #203957;
        font-size: 13px;
        font-weight: 750;
    }

    .lecturer-info small {
        color: #8290a4;
        font-size: 11px;
    }

    .lecturer-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .meta-chip {
        background: #edf4fc;
        color: #4776a9;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 650;
    }

    .found-badge {
        background: #e5f8ed;
        color: #198754;
        padding: 6px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 750;
    }

    .not-found-badge {
        background: #fff3e5;
        color: #bd7925;
        padding: 6px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 750;
    }

    .lecturer-body {
        padding: 15px 17px 17px;
    }

    .detail-title {
        color: #536a85;
        font-size: 11px;
        font-weight: 750;
        margin: 0 0 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .schedule-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 680px;
    }

    .schedule-table th {
        background: #eef5fc;
        color: #526b87;
        font-size: 10px;
        font-weight: 750;
        padding: 11px 12px;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #e0eaf4;
    }

    .schedule-table td {
        color: #394e67;
        font-size: 11px;
        padding: 11px 12px;
        border-bottom: 1px solid #eff3f7;
        white-space: nowrap;
    }

    .schedule-table tr:last-child td {
        border-bottom: none;
    }

    .course-name {
        color: #244c79;
        font-weight: 700;
    }

    .room-chip {
        display: inline-block;
        background: #f0edff;
        color: #7157b4;
        padding: 5px 8px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 10px;
    }

    .empty-state {
        text-align: center;
        padding: 19px;
        border: 1px dashed #dce6f1;
        border-radius: 10px;
        color: #8b98a9;
        font-size: 12px;
        background: #fbfdff;
    }

    .empty-state strong {
        display: block;
        color: #62758d;
        margin-bottom: 5px;
    }

    .no-result {
        display: none;
        padding: 35px 15px;
        text-align: center;
        color: #8290a4;
        font-size: 13px;
    }

    .no-result .symbol {
        font-size: 30px;
        margin-bottom: 9px;
    }

    .api-footnote {
        color: #8290a4;
        font-size: 11px;
        margin-top: 14px;
        line-height: 1.6;
    }

    @media (max-width: 1100px) {
        .integrasi-stats { grid-template-columns: repeat(2, 1fr); }
        .api-status-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 650px) {
        .integrasi-stats { grid-template-columns: 1fr 1fr; gap: 9px; }
        .stat-card { padding: 13px; gap: 9px; }
        .stat-icon { width: 38px; height: 38px; font-size: 17px; }
        .stat-card strong { font-size: 19px; }
        .api-status-grid { grid-template-columns: repeat(2, 1fr); }
        .panel { padding: 14px; }
        .integrasi-header h2 { font-size: 21px; }
    }
</style>

<div class="integrasi-page">

    <!-- HEADER -->
    <div class="integrasi-header">
        <div>
            <h2>Integrasi API</h2>
            <p>Monitoring dan pencocokan data dosen, mata kuliah, serta jadwal perkuliahan.</p>
        </div>

        <div class="header-label">
            <span>●</span> Sistem Integrasi Data
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="integrasi-stats">

        <div class="stat-card">
            <div class="stat-icon stat-blue">👨‍🏫</div>
            <div>
                <small>Total Dosen Lokal</small>
                <strong><?= number_format($total_dosen) ?></strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-green">✓</div>
            <div>
                <small>Dosen Ditemukan</small>
                <strong><?= number_format($dosen_ditemukan) ?></strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-orange">📚</div>
            <div>
                <small>Total Pengajaran</small>
                <strong><?= number_format($total_pengajaran) ?></strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-purple">🗓</div>
            <div>
                <small>Total Jadwal Dosen</small>
                <strong><?= number_format($total_jadwal) ?></strong>
            </div>
        </div>

    </div>

    <!-- STATUS API -->
    <div class="panel">
        <div class="panel-heading">
            <div>
                <h5>Status Koneksi API</h5>
                <p>Memantau koneksi seluruh sumber data integrasi.</p>
            </div>
        </div>

        <div class="api-status-grid">

            <?php
            $apiLabels = [
                'dosen_lokal' => 'Database Dosen Lokal',
                'matkul' => 'API Mata Kuliah',
                'dosen_api' => 'API Dosen',
                'pengampu' => 'API Pengampu',
                'jadwal' => 'API Jadwal',
            ];
            ?>

            <?php foreach ($apiLabels as $key => $label): ?>
                <?php $online = !empty($status_api[$key]); ?>

                <div class="api-status">
                    <span class="api-name"><?= esc($label) ?></span>

                    <?php if ($online): ?>
                        <span class="status-pill status-online">
                            ● Terhubung
                        </span>
                    <?php else: ?>
                        <span class="status-pill status-offline">
                            ● Tidak Terhubung
                        </span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>

        <div class="api-footnote">
            Data API Kelompok 2 dan Kelompok 3 ditampilkan berdasarkan respons yang berhasil diterima.
            Status koneksi menunjukkan hasil request, bukan jaminan seluruh data memiliki pasangan.
        </div>
    </div>

    <!-- DAFTAR DOSEN -->
    <div class="panel">

        <div class="panel-heading">
            <div>
                <h5>Data Integrasi Dosen</h5>
                <p>Daftar dosen lokal beserta mata kuliah dan jadwal mengajar hasil pencocokan API.</p>
            </div>

            <span class="header-label">
                <?= number_format($total_dosen) ?> Dosen
            </span>
        </div>

        <!-- PENCARIAN -->
        <div class="search-area">
            <div class="search-box">
                <span class="search-symbol">⌕</span>
                <input
                    type="text"
                    id="searchIntegrasi"
                    placeholder="Cari nama dosen, kode dosen, atau mata kuliah..."
                    autocomplete="off"
                >
            </div>

            <span class="result-count" id="resultCount">
                Menampilkan <?= number_format($total_dosen) ?> dosen
            </span>
        </div>

        <!-- KARTU DOSEN -->
        <div id="lecturerList">

            <?php foreach ($hasil_integrasi as $index => $dosen): ?>

                <?php
                $kataNama = preg_split('/\s+/', trim($dosen['nama']));
                $inisial = '';

                foreach (array_slice($kataNama, 0, 2) as $kata) {
                    $inisial .= mb_substr($kata, 0, 1);
                }

                $kataCari = strtolower(
                    ($dosen['nama'] ?? '') . ' ' .
                    ($dosen['kode_dosen'] ?? '') . ' ' .
                    ($dosen['nip'] ?? '')
                );

                foreach ($dosen['mata_kuliah'] as $matkul) {
                    $kataCari .= ' ' . strtolower(
                        ($matkul['nama_matkul'] ?? '') . ' ' .
                        ($matkul['kode_matkul'] ?? '') . ' ' .
                        ($matkul['nama_kelas'] ?? '')
                    );
                }

                foreach ($dosen['jadwal'] as $jadwal) {
                    $kataCari .= ' ' . strtolower(
                        ($jadwal['hari'] ?? '') . ' ' .
                        ($jadwal['ruangan'] ?? '') . ' ' .
                        ($jadwal['nama_matkul'] ?? '')
                    );
                }
                ?>

                <div
                    class="lecturer-card"
                    data-search="<?= esc($kataCari) ?>"
                >

                    <div class="lecturer-top">

                        <div class="lecturer-info">
                            <div class="lecturer-avatar">
                                <?= esc(mb_strtoupper($inisial)) ?>
                            </div>

                            <div>
                                <h6><?= esc($dosen['nama']) ?></h6>
                                <small>
                                    <?= esc($dosen['kode_dosen']) ?>
                                    &nbsp;•&nbsp;
                                    NIP: <?= esc($dosen['nip']) ?>
                                </small>
                            </div>
                        </div>

                        <div class="lecturer-meta">

                            <span class="meta-chip">
                                <?= number_format($dosen['jumlah_matkul']) ?> Mata Kuliah
                            </span>

                            <span class="meta-chip">
                                <?= number_format($dosen['jumlah_jadwal']) ?> Jadwal
                            </span>

                            <?php if ($dosen['status'] === 'Ditemukan'): ?>
                                <span class="found-badge">✓ Ditemukan</span>
                            <?php else: ?>
                                <span class="not-found-badge">Belum ditemukan</span>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="lecturer-body">

                        <?php if (!empty($dosen['jadwal'])): ?>

                            <h6 class="detail-title">Detail Mata Kuliah dan Jadwal Mengajar</h6>

                            <div class="table-responsive">
                                <table class="schedule-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Mata Kuliah</th>
                                            <th>Kode MK</th>
                                            <th>Kelas</th>
                                            <th>Semester</th>
                                            <th>Hari</th>
                                            <th>Waktu</th>
                                            <th>Ruangan</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($dosen['jadwal'] as $nomor => $jadwal): ?>
                                            <tr>
                                                <td><?= $nomor + 1 ?></td>

                                                <td class="course-name">
                                                    <?= esc($jadwal['nama_matkul']) ?>
                                                </td>

                                                <td><?= esc($jadwal['kode_matkul']) ?></td>

                                                <td><?= esc($jadwal['nama_kelas']) ?></td>

                                                <td><?= esc($jadwal['semester']) ?></td>

                                                <td><?= esc($jadwal['hari']) ?></td>

                                                <td>
                                                    <?= esc($jadwal['jam_mulai']) ?>
                                                    -
                                                    <?= esc($jadwal['jam_selesai']) ?>
                                                </td>

                                                <td>
                                                    <span class="room-chip">
                                                        <?= esc($jadwal['ruangan']) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php elseif (!empty($dosen['mata_kuliah'])): ?>

                            <h6 class="detail-title">Mata Kuliah yang Diampu</h6>

                            <div class="table-responsive">
                                <table class="schedule-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Mata Kuliah</th>
                                            <th>Kode MK</th>
                                            <th>Kelas</th>
                                            <th>Semester</th>
                                            <th>Status Jadwal</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($dosen['mata_kuliah'] as $nomor => $matkul): ?>
                                            <tr>
                                                <td><?= $nomor + 1 ?></td>

                                                <td class="course-name">
                                                    <?= esc($matkul['nama_matkul']) ?>
                                                </td>

                                                <td><?= esc($matkul['kode_matkul']) ?></td>

                                                <td><?= esc($matkul['nama_kelas']) ?></td>

                                                <td><?= esc($matkul['semester']) ?></td>

                                                <td>
                                                    <?php if ($matkul['jumlah_jadwal'] > 0): ?>
                                                        <span class="status-pill status-online">
                                                            <?= $matkul['jumlah_jadwal'] ?> Jadwal
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="status-pill status-offline">
                                                            Belum ada jadwal
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php else: ?>

                            <div class="empty-state">
                                <strong>Data pengajaran belum ditemukan</strong>
                                Dosen ini belum memiliki pasangan data berdasarkan kode dosen
                                pada API Pengampu.
                            </div>

                        <?php endif; ?>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <div class="no-result" id="noResult">
            <div class="symbol">🔎</div>
            <strong>Data tidak ditemukan</strong>
            Coba gunakan nama dosen, kode dosen, atau nama mata kuliah yang lain.
        </div>

    </div>

    <!-- INFORMASI SUMBER DATA -->
    <div class="panel">
        <div class="panel-heading">
            <div>
                <h5>Ringkasan Sumber Data API</h5>
                <p>Jumlah data yang diterima dari masing-masing sumber.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Sumber Data</th>
                        <th>Jumlah Data</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Database Dosen Lokal</td>
                        <td><?= number_format($total_dosen) ?></td>
                        <td><span class="status-pill status-online">Aktif</span></td>
                    </tr>

                    <tr>
                        <td>API Dosen Kelompok 2</td>
                        <td><?= number_format($total_dosen_api) ?></td>
                        <td>
                            <span class="status-pill <?= !empty($status_api['dosen_api']) ? 'status-online' : 'status-offline' ?>">
                                <?= !empty($status_api['dosen_api']) ? 'Terhubung' : 'Terputus' ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>API Mata Kuliah Kelompok 3</td>
                        <td><?= number_format($total_matkul_api) ?></td>
                        <td>
                            <span class="status-pill <?= !empty($status_api['matkul']) ? 'status-online' : 'status-offline' ?>">
                                <?= !empty($status_api['matkul']) ? 'Terhubung' : 'Terputus' ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>API Pengampu Kelompok 2</td>
                        <td><?= number_format($total_pengampu_api) ?></td>
                        <td>
                            <span class="status-pill <?= !empty($status_api['pengampu']) ? 'status-online' : 'status-offline' ?>">
                                <?= !empty($status_api['pengampu']) ? 'Terhubung' : 'Terputus' ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>API Jadwal Kelompok 2</td>
                        <td><?= number_format($total_jadwal_api) ?></td>
                        <td>
                            <span class="status-pill <?= !empty($status_api['jadwal']) ? 'status-online' : 'status-offline' ?>">
                                <?= !empty($status_api['jadwal']) ? 'Terhubung' : 'Terputus' ?>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchIntegrasi');
    const lecturerCards = document.querySelectorAll('.lecturer-card');
    const resultCount = document.getElementById('resultCount');
    const noResult = document.getElementById('noResult');

    function filterLecturers() {
        const keyword = searchInput.value
            .toLowerCase()
            .trim();

        let visibleCount = 0;

        lecturerCards.forEach(function (card) {
            const searchableText = card.dataset.search || '';
            const isMatch = searchableText.includes(keyword);

            card.style.display = isMatch ? '' : 'none';

            if (isMatch) {
                visibleCount++;
            }
        });

        resultCount.textContent =
            'Menampilkan ' + visibleCount + ' dari ' +
            lecturerCards.length + ' dosen';

        noResult.style.display =
            visibleCount === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterLecturers);
});
</script>

<?= $this->endSection() ?>
