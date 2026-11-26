<?php

namespace App\Controllers;

use App\Models\DosenModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class DosenWeb extends BaseController
{
    protected $dosenModel;
    protected $db;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->db = \Config\Database::connect();
    }

    // ==========================================
    // MENAMPILKAN DAFTAR DOSEN ADMIN
    // ==========================================
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('keyword'));

        $builder = $this->db->table('dosen d');

        $builder->select('
            d.*,
            j.nama_jabatan,
            sp.nama_status AS nama_status_prodi,
            sa.nama_status AS nama_status_aktivitas,
            p.nama_pendidikan,
            a.nama_agama
        ');

        $this->joinReferensi($builder);

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('d.nama', $keyword)
                ->orLike('d.nip', $keyword)
                ->orLike('d.kode_dosen', $keyword)
                ->groupEnd();
        }

        $data['dosen'] = $builder
            ->orderBy('d.id_dosen', 'ASC')
            ->get()
            ->getResultArray();

        $data['keyword'] = $keyword;

        return view('dosen/index', $data);
    }

    // ==========================================
    // DIREKTORI DOSEN UNTUK PENGUNJUNG PUBLIK
    // ==========================================
    public function publik()
    {
        $keyword = trim((string) $this->request->getGet('keyword'));

        $builder = $this->db->table('dosen d');

        $builder->select('
            d.id_dosen,
            d.kode_dosen,
            d.nip,
            d.nama,
            d.jabatan_fungsional,
            d.status_prodi,
            d.status_aktivitas,
            d.pendidikan_terakhir,
            d.tahun_lulus,
            d.jenis_kelamin,
            d.agama,
            j.nama_jabatan,
            sp.nama_status AS nama_status_prodi,
            sa.nama_status AS nama_status_aktivitas,
            p.nama_pendidikan,
            a.nama_agama
        ');

        $this->joinReferensi($builder);

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('d.nama', $keyword)
                ->orLike('d.nip', $keyword)
                ->orLike('d.kode_dosen', $keyword)
                ->groupEnd();
        }

        $data['dosen'] = $builder
            ->orderBy('d.id_dosen', 'ASC')
            ->get()
            ->getResultArray();

        $data['keyword'] = $keyword;

        return view('dosen/publik', $data);
    }

    // ==========================================
    // JOIN TABEL REFERENSI
    // ==========================================
    private function joinReferensi($builder)
    {
        $builder->join(
            'jabatan_fungsional j',
            'j.id_jabatan = d.id_jabatan',
            'left'
        );

        $builder->join(
            'status_prodi sp',
            'sp.id_status_prodi = d.id_status_prodi',
            'left'
        );

        $builder->join(
            'status_aktivitas sa',
            'sa.id_status_aktivitas = d.id_status_aktivitas',
            'left'
        );

        $builder->join(
            'pendidikan_terakhir p',
            'p.id_pendidikan = d.id_pendidikan',
            'left'
        );

        $builder->join(
            'agama a',
            'a.id_agama = d.id_agama',
            'left'
        );

        return $builder;
    }

    // ==========================================
    // MENAMPILKAN DETAIL DOSEN
    // ==========================================
    public function detail($id)
    {
        $dosen = $this->getDosenDetail($id);

        if (!$dosen) {
            throw PageNotFoundException::forPageNotFound(
                'Data dosen tidak ditemukan.'
            );
        }

        return view('dosen/detail', [
            'dosen' => $dosen
        ]);
    }

    // ==========================================
    // FORM TAMBAH DOSEN
    // ==========================================
    public function create()
{
    return view('dosen/form', [
        'dosen' => []
    ]);
}

    // ==========================================
    // FORM EDIT DOSEN
    // ==========================================
    public function edit($id)
    {
        $dosen = $this->getDosenDetail($id);

        if (!$dosen) {
            throw PageNotFoundException::forPageNotFound(
                'Data dosen tidak ditemukan.'
            );
        }

        return view('dosen/form', [
            'dosen' => $dosen
        ]);
    }

    // ==========================================
    // MENGAMBIL ID DATA REFERENSI
    // ==========================================
    private function getReferenceId(
        $table,
        $idColumn,
        $nameColumn,
        $value
    ) {
        $allowed = [
            'jabatan_fungsional' => [
                'id_jabatan',
                'nama_jabatan'
            ],
            'status_prodi' => [
                'id_status_prodi',
                'nama_status'
            ],
            'status_aktivitas' => [
                'id_status_aktivitas',
                'nama_status'
            ],
            'pendidikan_terakhir' => [
                'id_pendidikan',
                'nama_pendidikan'
            ],
            'agama' => [
                'id_agama',
                'nama_agama'
            ]
        ];

        if (
            !isset($allowed[$table]) ||
            $allowed[$table][0] !== $idColumn ||
            $allowed[$table][1] !== $nameColumn
        ) {
            throw new \RuntimeException(
                'Referensi database tidak valid.'
            );
        }

        $row = $this->db->table($table)
            ->select($idColumn)
            ->where($nameColumn, $value)
            ->get()
            ->getRowArray();

        return $row[$idColumn] ?? null;
    }

    // ==========================================
    // MEMPERSIAPKAN DATA FORM
    // ==========================================
    private function getFormData()
    {
        $kodeDosen = trim((string) $this->request->getPost('kode_dosen'));
        $nip = trim((string) $this->request->getPost('nip'));
        $nama = trim((string) $this->request->getPost('nama'));

        $jabatan = trim((string) $this->request->getPost('jabatan_fungsional'));
        $statusProdi = trim((string) $this->request->getPost('status_prodi'));
        $statusAktivitas = trim((string) $this->request->getPost('status_aktivitas'));
        $pendidikan = trim((string) $this->request->getPost('pendidikan_terakhir'));
        $agama = trim((string) $this->request->getPost('agama'));

        $jenisKelamin = trim((string) $this->request->getPost('jenis_kelamin'));

        $tahunLulus = $this->request->getPost('tahun_lulus');
        $noHp = trim((string) $this->request->getPost('no_hp'));

        // Validasi input wajib
        if (
            $kodeDosen === '' ||
            $nip === '' ||
            $nama === '' ||
            $jabatan === '' ||
            $statusProdi === '' ||
            $statusAktivitas === '' ||
            $pendidikan === '' ||
            $agama === '' ||
            $jenisKelamin === ''
        ) {
            throw new \InvalidArgumentException(
                'Semua kolom wajib harus diisi.'
            );
        }

        // Validasi NIP
        if (!preg_match('/^[0-9]{18}$/', $nip)) {
            throw new \InvalidArgumentException(
                'NIP harus terdiri dari 18 digit angka.'
            );
        }

        // Mengambil ID referensi
        $idJabatan = $this->getReferenceId(
            'jabatan_fungsional',
            'id_jabatan',
            'nama_jabatan',
            $jabatan
        );

        $idStatusProdi = $this->getReferenceId(
            'status_prodi',
            'id_status_prodi',
            'nama_status',
            $statusProdi
        );

        $idStatusAktivitas = $this->getReferenceId(
            'status_aktivitas',
            'id_status_aktivitas',
            'nama_status',
            $statusAktivitas
        );

        $idPendidikan = $this->getReferenceId(
            'pendidikan_terakhir',
            'id_pendidikan',
            'nama_pendidikan',
            $pendidikan
        );

        $idAgama = $this->getReferenceId(
            'agama',
            'id_agama',
            'nama_agama',
            $agama
        );

        if (
            $idJabatan === null ||
            $idStatusProdi === null ||
            $idStatusAktivitas === null ||
            $idPendidikan === null ||
            $idAgama === null
        ) {
            throw new \InvalidArgumentException(
                'Pilihan referensi tidak ditemukan di database.'
            );
        }

        // Validasi jenis kelamin
        if (!in_array(
            $jenisKelamin,
            ['Laki-laki', 'Perempuan'],
            true
        )) {
            throw new \InvalidArgumentException(
                'Jenis kelamin tidak valid.'
            );
        }

        // Validasi tahun lulus
        if ($tahunLulus !== null && $tahunLulus !== '') {
            if (
                !ctype_digit((string) $tahunLulus) ||
                (int) $tahunLulus < 1900 ||
                (int) $tahunLulus > 2100
            ) {
                throw new \InvalidArgumentException(
                    'Tahun lulus tidak valid.'
                );
            }

            $tahunLulus = (int) $tahunLulus;
        } else {
            $tahunLulus = null;
        }

        return [
            'kode_dosen' => $kodeDosen,
            'nip' => $nip,
            'nama' => $nama,

            'id_jabatan' => $idJabatan,
            'id_status_prodi' => $idStatusProdi,
            'id_status_aktivitas' => $idStatusAktivitas,
            'id_pendidikan' => $idPendidikan,
            'id_agama' => $idAgama,

            // Sinkronisasi kolom teks lama
            'jabatan_fungsional' => $jabatan,
            'status_prodi' => $statusProdi,
            'status_aktivitas' => $statusAktivitas,
            'pendidikan_terakhir' => $pendidikan,
            'agama' => $agama,

            'tahun_lulus' => $tahunLulus,
            'jenis_kelamin' => $jenisKelamin,
            'no_hp' => $noHp !== '' ? $noHp : null
        ];
    }

    // ==========================================
    // MENYIMPAN DOSEN BARU
    // ==========================================
    public function store()
    {
        try {
            $data = $this->getFormData();

            // Cek kode dosen duplikat
            $kodeExists = $this->dosenModel
                ->where('kode_dosen', $data['kode_dosen'])
                ->first();

            if ($kodeExists) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kode dosen sudah digunakan.');
            }

            // Cek NIP duplikat
            $nipExists = $this->dosenModel
                ->where('nip', $data['nip'])
                ->first();

            if ($nipExists) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'NIP sudah digunakan.');
            }

            $this->db->transBegin();

            $this->dosenModel->insert($data);

            if ($this->db->transStatus() === false) {
                throw new \RuntimeException(
                    'Data dosen gagal disimpan.'
                );
            }

            $this->db->transCommit();

            return redirect()->to(site_url('dosen'))
                ->with('success', 'Data dosen berhasil ditambahkan.');

        } catch (Throwable $e) {
            $this->db->transRollback();

            log_message('error', 'Store dosen: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Data dosen gagal disimpan. Periksa kembali data yang dimasukkan.'
                );
        }
    }

    // ==========================================
    // MEMPERBARUI DATA DOSEN
    // ==========================================
    public function update($id)
    {
        try {
            $existing = $this->dosenModel->find($id);

            if (!$existing) {
                throw PageNotFoundException::forPageNotFound(
                    'Data dosen tidak ditemukan.'
                );
            }

            $data = $this->getFormData();

            // Cek kode dosen milik data lain
            $kodeExists = $this->db->table('dosen')
                ->where('kode_dosen', $data['kode_dosen'])
                ->where('id_dosen !=', $id)
                ->countAllResults();

            if ($kodeExists > 0) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kode dosen sudah digunakan oleh dosen lain.'
                    );
            }

            // Cek NIP milik data lain
            $nipExists = $this->db->table('dosen')
                ->where('nip', $data['nip'])
                ->where('id_dosen !=', $id)
                ->countAllResults();

            if ($nipExists > 0) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'NIP sudah digunakan oleh dosen lain.'
                    );
            }

            $this->db->transBegin();

            $this->dosenModel->update($id, $data);

            if ($this->db->transStatus() === false) {
                throw new \RuntimeException(
                    'Database gagal memperbarui data dosen.'
                );
            }

            $this->db->transCommit();

            return redirect()->to(site_url('dosen'))
                ->with('success', 'Data dosen berhasil diperbarui.');

        } catch (Throwable $e) {
            $this->db->transRollback();

            log_message(
                'error',
                'Update dosen ID ' . $id . ': ' . $e->getMessage()
            );

            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Data dosen gagal diperbarui. Periksa kembali data yang dimasukkan.'
                );
        }
    }

    // ==========================================
    // MENGHAPUS DATA DOSEN
    // ==========================================
    public function delete($id)
    {
        try {
            $existing = $this->dosenModel->find($id);

            if (!$existing) {
                return redirect()->to(site_url('dosen'))
                    ->with('error', 'Data dosen tidak ditemukan.');
            }

            $this->dosenModel->delete($id);

            return redirect()->to(site_url('dosen'))
                ->with('success', 'Data dosen berhasil dihapus.');

        } catch (Throwable $e) {
            log_message('error', 'Delete dosen: ' . $e->getMessage());

            return redirect()->to(site_url('dosen'))
                ->with('error', 'Data dosen gagal dihapus.');
        }
    }

    // ==========================================
    // QUERY DETAIL DOSEN DENGAN JOIN
    // ==========================================
    private function getDosenDetail($id)
    {
        return $this->db->table('dosen d')
            ->select('
                d.*,
                j.nama_jabatan,
                sp.nama_status AS nama_status_prodi,
                sa.nama_status AS nama_status_aktivitas,
                p.nama_pendidikan,
                a.nama_agama
            ')
            ->join(
                'jabatan_fungsional j',
                'j.id_jabatan = d.id_jabatan',
                'left'
            )
            ->join(
                'status_prodi sp',
                'sp.id_status_prodi = d.id_status_prodi',
                'left'
            )
            ->join(
                'status_aktivitas sa',
                'sa.id_status_aktivitas = d.id_status_aktivitas',
                'left'
            )
            ->join(
                'pendidikan_terakhir p',
                'p.id_pendidikan = d.id_pendidikan',
                'left'
            )
            ->join(
                'agama a',
                'a.id_agama = d.id_agama',
                'left'
            )
            ->where('d.id_dosen', $id)
            ->get()
            ->getRowArray();
    }
}
