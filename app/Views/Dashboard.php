<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .dashboard-page {
        font-family: 'Inter', sans-serif;
        color: #172f50;
    }

    /* ANIMASI */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(25px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes floatIcon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-7px); }
    }

    @keyframes glow {
        0%, 100% { box-shadow: 0 8px 25px rgba(37,99,235,.15); }
        50% { box-shadow: 0 12px 35px rgba(37,99,235,.3); }
    }

    .dashboard-page .welcome {
        position: relative;
        overflow: hidden;
        background: linear-gradient(115deg, #102f52, #1d4ed8, #4385f5);
        border-radius: 20px;
        padding: 30px;
        color: white;
        margin-bottom: 26px;
        animation: fadeUp .65s ease both, glow 5s ease-in-out infinite;
    }

    .welcome::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        right: -45px;
        top: -100px;
    }

    .welcome-content {
        position: relative;
        z-index: 1;
    }

    .welcome h2 {
        font-size: 25px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .welcome p {
        font-size: 13px;
        color: #e0ecff;
        line-height: 1.8;
        max-width: 550px;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 30px;
        font-size: 11px;
        margin-bottom: 17px;
    }

    .welcome-icon {
        font-size: 43px;
        animation: floatIcon 3s ease-in-out infinite;
    }

    /* TOMBOL HOME DAN LOGOUT */
    .dashboard-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .dashboard-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 11px 17px;
        border-radius: 11px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: all .3s ease;
        border: 1px solid rgba(255,255,255,.25);
        position: relative;
        overflow: hidden;
    }

    .dashboard-action .action-icon {
        display: inline-block;
        transition: transform .3s ease;
        font-size: 16px;
    }

    .home-action {
        background: rgba(255,255,255,.16);
        color: white;
    }

    .home-action:hover {
        background: white;
        color: #1d4ed8;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,.15);
    }

    .logout-action {
        background: rgba(239,68,68,.18);
        color: #fff;
        border-color: rgba(255,255,255,.25);
    }

    .logout-action:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(127,29,29,.25);
    }

    .dashboard-action:hover .action-icon {
        transform: rotate(-12deg) scale(1.2);
    }

    .dashboard-action:active {
        transform: scale(.96);
    }

    /* STATISTIK */
    .dashboard-page .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 19px;
        margin-bottom: 28px;
    }

    .dashboard-page .stat-card {
        position: relative;
        overflow: hidden;
        background: white;
        padding: 24px;
        border-radius: 17px;
        border: 1px solid #edf1f7;
        box-shadow: 0 4px 18px rgba(30,41,59,.04);
        transition: all .35s ease;
        animation: fadeUp .7s ease backwards;
    }

    .stat-card:nth-child(1) { animation-delay: .12s; }
    .stat-card:nth-child(2) { animation-delay: .24s; }
    .stat-card:nth-child(3) { animation-delay: .36s; }

    .stat-card::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #2563eb, #60a5fa);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .35s ease;
    }

    .stat-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 15px 35px rgba(30,41,59,.10);
    }

    .stat-card:hover::after { transform: scaleX(1); }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .stat-icon {
        width: 53px;
        height: 53px;
        display: grid;
        place-items: center;
        border-radius: 15px;
        font-size: 23px;
        transition: all .35s ease;
    }

    .stat-card:hover .stat-icon {
        transform: rotate(-8deg) scale(1.12);
    }

    .blue { background: #eaf2ff; }
    .green { background: #e6f8ef; }
    .orange { background: #fff3e6; }

    .stat-card p {
        color: #8492a6;
        font-size: 12px;
        font-weight: 500;
    }

    .stat-card h2 {
        font-size: 31px;
        font-weight: 800;
        margin-top: 9px;
        color: #172f50;
    }

    .stat-description {
        margin-top: 8px;
        font-size: 11px;
        color: #94a3b8;
    }

    .stat-progress {
        height: 5px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 17px;
    }

    .stat-progress span {
        display: block;
        height: 100%;
        width: 0;
        border-radius: 10px;
        transition: width 1.3s ease;
    }

    /* TABEL */
    .dashboard-page .section-card {
        background: white;
        padding: 25px;
        border-radius: 17px;
        border: 1px solid #edf1f7;
        box-shadow: 0 4px 18px rgba(30,41,59,.04);
        animation: fadeUp .8s ease .25s backwards;
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
        font-weight: 800;
        color: #172f50;
    }

    .section-header p {
        font-size: 12px;
        color: #8492a6;
        margin-top: 7px;
    }

    .section-label {
        display: inline-block;
        font-size: 10px;
        color: #2563eb;
        background: #eff6ff;
        padding: 6px 10px;
        border-radius: 20px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    /* PENCARIAN */
    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #dce5f0;
        border-radius: 11px;
        padding: 0 14px;
        width: 320px;
        transition: .25s;
    }

    .search-box:focus-within {
        border-color: #3478f6;
        box-shadow: 0 0 0 4px rgba(52,120,246,.10);
        background: white;
        transform: translateY(-2px);
    }

    .search-box span {
        font-size: 18px;
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

    /* TABEL */
    .table-wrap {
        overflow-x: auto;
        border-radius: 12px;
    }

    .dashboard-page table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .dashboard-page th {
        text-align: left;
        color: #8492a6;
        font-size: 11px;
        font-weight: 700;
        padding: 16px 12px;
        background: #f8fafc;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .dashboard-page td {
        padding: 17px 12px;
        border-bottom: 1px solid #edf1f6;
        font-size: 12px;
        color: #475569;
        vertical-align: middle;
    }

    .dashboard-page tbody tr {
        transition: all .25s ease;
    }

    .dashboard-page tbody tr:hover {
        background: #f0f7ff;
    }

    .id-label {
        color: #475569;
        font-weight: 700;
    }

    .kode-label {
        color: #2563eb;
        font-weight: 700;
        background: #eff6ff;
        padding: 7px 11px;
        border-radius: 7px;
        display: inline-block;
    }

    .detail-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #2563eb;
        text-decoration: none;
        font-weight: 700;
        padding: 8px 12px;
        background: #eff6ff;
        border-radius: 8px;
        transition: all .25s ease;
        white-space: nowrap;
    }

    .detail-btn:hover {
        color: white;
        background: #2563eb;
        transform: translateX(3px);
        box-shadow: 0 5px 12px rgba(37,99,235,.2);
    }

    .empty {
        text-align: center;
        color: #94a3b8;
        padding: 35px;
    }

    .empty-icon {
        font-size: 35px;
        margin-bottom: 10px;
    }

    .table-info {
        color: #94a3b8;
        font-size: 11px;
        margin-top: 16px;
    }

    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 17px;
        padding-top: 15px;
        border-top: 1px solid #edf1f7;
    }

    @media(max-width: 850px) {
        .dashboard-page .stats {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 550px) {
        .section-header {
            align-items: stretch;
            flex-direction: column;
        }

        .search-box { width: 100%; }
        .dashboard-page .welcome { padding: 23px; }
        .dashboard-page .section-card { padding: 17px; }
        .welcome h2 { font-size: 21px; }

        .dashboard-actions {
            flex-direction: column;
        }

        .dashboard-action {
            width: 100%;
        }
    }

    @media(prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }
</style>


<div class="dashboard-page">

    <!-- WELCOME SECTION -->
    <section class="welcome">

        <div class="welcome-content">

            <div class="welcome-badge">
                <span>●</span>
                SISTEM INFORMASI DATA DOSEN TRPL
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; gap:20px; flex-wrap:wrap;">

                <div>
                    <h2>Selamat Datang, Admin! 👋</h2>

                    <p>
                        Selamat datang di Sistem Informasi Data Dosen TRPL.
                        Kelola dan pantau informasi dosen dengan lebih mudah,
                        cepat, dan terorganisir.
                    </p>

                    <!-- TOMBOL HOME DAN LOGOUT -->
                    <div class="dashboard-actions">

                        <a href="<?= site_url('/') ?>"
                           class="dashboard-action home-action">

                            <span class="action-icon">🏠</span>
                            Kembali ke Home

                        </a>

                        <a href="<?= site_url('logout') ?>"
                           class="dashboard-action logout-action"
                           onclick="return confirmLogout(event)">

                            <span class="action-icon">🚪</span>
                            Logout

                        </a>

                    </div>
                </div>

                <div class="welcome-icon">🎓</div>

            </div>

        </div>

    </section>


    <!-- STATISTIK -->
    <section class="stats">

        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <p>Total Data Dosen</p>
                    <h2 class="counter"
                        data-target="<?= (int) ($totalDosen ?? 0) ?>">0</h2>
                    <div class="stat-description">Seluruh data dosen</div>
                </div>
                <div class="stat-icon blue">👨‍🏫</div>
            </div>

            <div class="stat-progress">
                <span data-width="100%" style="background:#3b82f6;"></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <p>Dosen Aktif</p>
                    <h2 class="counter"
                        data-target="<?= (int) ($totalAktif ?? 0) ?>"
                        style="color:#16a34a;">0</h2>
                    <div class="stat-description">Status aktivitas aktif</div>
                </div>
                <div class="stat-icon green">✓</div>
            </div>

            <div class="stat-progress">
                <span data-width="<?= ($totalDosen ?? 0) > 0 ? round(($totalAktif ?? 0) / $totalDosen * 100) : 0 ?>%"
                       style="background:#22c55e;"></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <p>Dosen Tidak Aktif</p>
                    <h2 class="counter"
                        data-target="<?= (int) ($totalTidakAktif ?? 0) ?>"
                        style="color:#f97316;">0</h2>
                    <div class="stat-description">Status selain aktif</div>
                </div>
                <div class="stat-icon orange">◷</div>
            </div>

            <div class="stat-progress">
                <span data-width="<?= ($totalDosen ?? 0) > 0 ? round(($totalTidakAktif ?? 0) / $totalDosen * 100) : 0 ?>%"
                       style="background:#f97316;"></span>
            </div>
        </div>

    </section>


    <!-- DAFTAR DOSEN -->
    <section class="section-card">

        <div class="section-header">

            <div>
                <span class="section-label">DATA MASTER</span>
                <h2>Daftar Data Dosen</h2>
                <p>Informasi dosen yang tersimpan dalam sistem.</p>
            </div>

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


        <!-- TABEL -->
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
                                <td><?= $i + 1 ?></td>

                                <td>
                                    <span class="id-label">
                                        <?= esc($item['id_dosen'] ?? '-') ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="kode-label">
                                        <?= esc($item['kode_dosen'] ?? '-') ?>
                                    </span>
                                </td>

                                <td>
                                    <strong>
                                        <?= esc($item['nama'] ?? '-') ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= esc($item['nip'] ?? '-') ?>
                                </td>

                                <td>
                                    <a
                                        class="detail-btn"
                                        href="<?= site_url('dosen/' . rawurlencode((string) ($item['id_dosen'] ?? ''))) ?>"
                                    >
                                        Lihat detail <span>→</span>
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="empty">
                                <div class="empty-icon">📂</div>
                                <strong>Belum ada data dosen</strong>
                                <p style="margin-top:7px;">
                                    Data dosen belum tersedia dalam sistem.
                                </p>
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- FOOTER TABEL -->
        <div class="table-footer">

            <p class="table-info" id="jumlahTampil">
                Menampilkan <?= count($dosen ?? []) ?> data dosen.
            </p>

            <p class="table-info">
                TRPL Information System · Kelompok 4
            </p>

        </div>

    </section>


    <footer style="text-align:center; padding:25px 10px 5px; color:#94a3b8; font-size:11px;">
        © <?= date('Y') ?> TRPL Information System. All rights reserved.
    </footer>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    // ANIMASI ANGKA STATISTIK
    const counters = document.querySelectorAll('.counter');

    counters.forEach(function (counter) {

        const target = Number(counter.dataset.target) || 0;
        const duration = 1100;
        const startTime = performance.now();

        function updateCounter(currentTime) {
            const progress = Math.min(
                (currentTime - startTime) / duration,
                1
            );

            const eased = 1 - Math.pow(1 - progress, 3);

            counter.textContent = Math.floor(target * eased);

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        }

        requestAnimationFrame(updateCounter);
    });


    // ANIMASI PROGRESS BAR
    document.querySelectorAll('.stat-progress span').forEach(function (bar) {

        const width = bar.dataset.width;

        setTimeout(function () {
            bar.style.width = width;
        }, 300);
    });


    // PENCARIAN DATA DOSEN
    const searchInput = document.getElementById('searchDosen');
    const tableBody = document.querySelector('#tabelDosen tbody');
    const rows = tableBody.querySelectorAll('tr');
    const jumlahTampil = document.getElementById('jumlahTampil');

    const jumlahAwal = <?= (int) count($dosen ?? []) ?>;

    searchInput.addEventListener('input', function () {

        const keyword = this.value.toLowerCase().trim();
        let jumlah = 0;

        rows.forEach(function (row) {

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
            'Menampilkan ' + jumlah +
            ' dari ' + jumlahAwal + ' data dosen.';
    });

});


// KONFIRMASI LOGOUT
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
</script>

<?= $this->endSection() ?>
