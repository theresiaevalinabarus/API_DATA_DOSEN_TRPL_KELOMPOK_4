<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$fields = [
    'ID Dosen' => 'id_dosen',
    'Kode Dosen' => 'kode_dosen',
    'NIP' => 'nip',
    'Nama Lengkap' => 'nama',
    'Jabatan Fungsional' => 'jabatan_fungsional',
    'Status Prodi' => 'status_prodi',
    'Pendidikan Terakhir' => 'pendidikan_terakhir',
    'Status Aktivitas' => 'status_aktivitas',
    'Tahun Lulus' => 'tahun_lulus',
    'Jenis Kelamin' => 'jenis_kelamin',
    'Nomor HP' => 'no_hp',
    'Agama' => 'agama'
];
?>

<style>
    .profile-banner {
        background: linear-gradient(110deg, #173f7a, #4385f5);
        padding: 28px;
        color: white;
        border-radius: 17px;
        margin-bottom: 25px;
    }

    .profile-banner h2 {
        font-size: 22px;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .profile-banner p {
        font-size: 12px;
        color: #e0ecff;
        margin-bottom: 0;
    }

    .profile-card {
        background: white;
        padding: 28px;
        border-radius: 17px;
        border: 1px solid #edf1f7;
        box-shadow: 0 4px 18px #1e293b08;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 18px;
        padding-bottom: 25px;
        border-bottom: 1px solid #edf1f7;
        margin-bottom: 25px;
    }

    .profile-icon {
        width: 70px;
        height: 70px;
        background: #eaf2ff;
        border-radius: 18px;
        display: grid;
        place-items: center;
        font-size: 32px;
        flex-shrink: 0;
    }

    .profile-header h2 {
        color: #17365e;
        font-size: 19px;
        margin-bottom: 7px;
        font-weight: 700;
    }

    .profile-header p {
        color: #8492a6;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .profile-header .kode-dosen {
        color: #2563eb;
        font-weight: 700;
    }

    .section-title {
        font-size: 15px;
        color: #17365e;
        margin-bottom: 18px;
        font-weight: 700;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .detail-item {
        padding: 16px;
        background: #f8fafc;
        border: 1px solid #edf1f7;
        border-radius: 11px;
        transition: .2s ease;
    }

    .detail-item:hover {
        background: #f1f6ff;
        border-color: #d5e4ff;
    }

    .detail-item small {
        display: block;
        color: #8492a6;
        font-size: 11px;
        margin-bottom: 8px;
    }

    .detail-item strong {
        color: #253d5c;
        font-size: 13px;
        overflow-wrap: anywhere;
    }

    .back-btn,
    .edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 17px;
        text-decoration: none;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        transition: .2s ease;
    }

    .back-btn {
        background: #eff6ff;
        color: #2563eb;
    }

    .back-btn:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .edit-btn {
        background: #f59e0b;
        color: white;
    }

    .edit-btn:hover {
        background: #d97706;
        color: white;
    }

    .profile-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 25px;
        padding-top: 22px;
        border-top: 1px solid #edf1f7;
    }

    @media(max-width: 600px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .profile-card {
            padding: 18px;
        }

        .profile-banner {
            padding: 22px;
        }

        .profile-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .profile-actions a {
            width: 100%;
        }
    }
</style>

<div class="container-fluid">

    <!-- Tombol Kembali -->
    <a href="<?= site_url('dosen') ?>" class="back-btn mb-3">
        ← Kembali ke Data Dosen
    </a>

    <!-- Banner Profil -->
    <section class="profile-banner">
        <h2>Detail Profil Dosen 👨‍🏫</h2>
        <p>
            Informasi lengkap dosen dalam Sistem Informasi Data Dosen TRPL.
        </p>
    </section>

    <!-- Kartu Biodata -->
    <section class="profile-card">

        <div class="profile-header">

            <div class="profile-icon">
                👨‍🏫
            </div>

            <div>
                <h2>
                    <?= esc($dosen['nama'] ?? 'Nama tidak tersedia') ?>
                </h2>

                <p>
                    ID Dosen:
                    <?= esc($dosen['id_dosen'] ?? '-') ?>
                </p>

                <p class="kode-dosen">
                    Kode Dosen:
                    <?= esc($dosen['kode_dosen'] ?? '-') ?>
                </p>
            </div>

        </div>

        <h3 class="section-title">
            Informasi Biodata Dosen
        </h3>

        <div class="detail-grid">

            <?php foreach ($fields as $label => $key): ?>

                <div class="detail-item">

                    <small>
                        <?= esc($label) ?>
                    </small>

                    <strong>
                        <?= esc(
                            ($dosen[$key] ?? '') !== ''
                                ? $dosen[$key]
                                : '-'
                        ) ?>
                    </strong>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- Tombol Aksi -->
        <div class="profile-actions">

            <a href="<?= site_url('dosen') ?>" class="back-btn">
                ← Kembali
            </a>

            <a
                href="<?= site_url('dosen/edit/' . rawurlencode((string) $dosen['id_dosen'])) ?>"
                class="edit-btn">

                ✏️ Edit Data Dosen

            </a>

        </div>

    </section>

</div>

<?= $this->endSection() ?>
