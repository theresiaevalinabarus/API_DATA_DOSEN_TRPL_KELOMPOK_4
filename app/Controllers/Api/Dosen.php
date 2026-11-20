<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DosenModel;

class Dosen extends BaseController
{
    protected $dosenModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
    }

    /**
     * Query data dosen.
     * API hanya menampilkan tiga kolom:
     * id_dosen, kode_dosen, dan nama.
     */
    private function queryDosen()
    {
        return $this->dosenModel->builder()
            ->select([
                'id_dosen',
                'kode_dosen',
                'nama'
            ]);
    }

    // =====================================
    // GET: SEMUA DATA DOSEN
    // =====================================

    public function index()
    {
        try {
            $data = $this->queryDosen()
                ->orderBy('id_dosen', 'ASC')
                ->get()
                ->getResultArray();

            return $this->response->setJSON([
                'status'      => true,
                'message'     => 'Data dosen berhasil diambil',
                'jumlah_data' => count($data),
                'data'        => $data
            ]);

        } catch (\Throwable $e) {

            log_message('error', 'GET semua dosen: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Gagal mengambil data dosen'
                ]);
        }
    }

    // =====================================
    // GET: DETAIL DOSEN BERDASARKAN ID
    // =====================================

    public function show($id)
    {
        if (!ctype_digit((string) $id) || (int) $id < 1) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'ID dosen harus berupa angka positif'
                ]);
        }

        try {
            $data = $this->queryDosen()
                ->where('id_dosen', (int) $id)
                ->get()
                ->getRowArray();

            if (!$data) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status'  => false,
                        'message' => 'Data dosen tidak ditemukan'
                    ]);
            }

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Detail dosen berhasil diambil',
                'data'    => $data
            ]);

        } catch (\Throwable $e) {

            log_message('error', 'GET detail dosen: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Gagal mengambil detail dosen'
                ]);
        }
    }

    // =====================================
    // GET: PENCARIAN DOSEN BERDASARKAN NAMA
    // =====================================

    public function search()
    {
        $nama = trim((string) $this->request->getGet('nama'));

        if ($nama === '') {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Parameter nama wajib diisi'
                ]);
        }

        try {
            $data = $this->queryDosen()
                ->like('nama', $nama)
                ->orderBy('nama', 'ASC')
                ->get()
                ->getResultArray();

            return $this->response->setJSON([
                'status'      => true,
                'message'     => 'Pencarian dosen berhasil',
                'jumlah_data' => count($data),
                'data'        => $data
            ]);

        } catch (\Throwable $e) {

            log_message('error', 'Pencarian dosen: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Gagal mencari data dosen'
                ]);
        }
    }

    // =====================================
    // GET: FILTER DOSEN
    // =====================================

    public function filter()
    {
        $status  = trim((string) $this->request->getGet('status'));
        $jabatan = trim((string) $this->request->getGet('jabatan'));

        if ($status === '') {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Parameter status wajib diisi'
                ]);
        }

        try {
            $builder = $this->queryDosen()
                ->where('status_aktivitas', $status);

            // Jabatan merupakan parameter tambahan.
            // Kolom jabatan hanya digunakan untuk filter,
            // tidak dikirimkan dalam respons API.

            if ($jabatan !== '') {
                $builder->where('jabatan_fungsional', $jabatan);
            }

            $data = $builder
                ->orderBy('nama', 'ASC')
                ->get()
                ->getResultArray();

            return $this->response->setJSON([
                'status'      => true,
                'message'     => 'Filter dosen berhasil',
                'jumlah_data' => count($data),
                'data'        => $data
            ]);

        } catch (\Throwable $e) {

            log_message('error', 'Filter dosen: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Gagal memfilter data dosen'
                ]);
        }
    }

    // =====================================
    // GET: PEMERIKSAAN KONEKSI DATABASE
    // =====================================

    public function cekKoneksi()
    {
        try {
            $this->dosenModel->db->query('SELECT 1');

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'API dan database berhasil terhubung'
            ]);

        } catch (\Throwable $e) {

            log_message('error', 'Cek koneksi API: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Koneksi database gagal'
                ]);
        }
    }
    // =====================================
// POST: TAMBAH DATA DOSEN
// =====================================

public function store()
{
    $data = $this->request->getJSON(true);

    if (!is_array($data) || empty($data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status'  => false,
                'message' => 'Body JSON wajib diisi'
            ]);
    }

    // ID dibuat otomatis oleh database.
    unset($data['id_dosen']);

    try {
        $id = $this->dosenModel->insert($data);

        if ($id === false) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen gagal ditambahkan',
                    'errors'  => $this->dosenModel->errors()
                ]);
        }

        return $this->response
            ->setStatusCode(201)
            ->setJSON([
                'status'   => true,
                'message'  => 'Data dosen berhasil ditambahkan',
                'id_dosen' => $id
            ]);

    } catch (\Throwable $e) {
        log_message('error', 'POST dosen: ' . $e->getMessage());

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menambahkan data'
            ]);
    }
}


// =====================================
// PUT: UBAH DATA DOSEN
// =====================================

public function update($id)
{
    if (!ctype_digit((string) $id) || (int) $id < 1) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status'  => false,
                'message' => 'ID dosen tidak valid'
            ]);
    }

    $data = $this->request->getJSON(true);

    if (!is_array($data) || empty($data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status'  => false,
                'message' => 'Body JSON wajib diisi'
            ]);
    }

    unset($data['id_dosen']);

    try {
        $dosen = $this->dosenModel->find((int) $id);

        if (!$dosen) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen tidak ditemukan'
                ]);
        }

        $berhasil = $this->dosenModel->update((int) $id, $data);

        if (!$berhasil) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen gagal diperbarui',
                    'errors'  => $this->dosenModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status'   => true,
            'message'  => 'Data dosen berhasil diperbarui',
            'id_dosen' => (int) $id
        ]);

    } catch (\Throwable $e) {
        log_message('error', 'PUT dosen: ' . $e->getMessage());

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat memperbarui data'
            ]);
    }
}


// =====================================
// DELETE: HAPUS DATA DOSEN
// =====================================

public function delete($id)
{
    if (!ctype_digit((string) $id) || (int) $id < 1) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status'  => false,
                'message' => 'ID dosen tidak valid'
            ]);
    }

    try {
        $dosen = $this->dosenModel->find((int) $id);

        if (!$dosen) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen tidak ditemukan'
                ]);
        }

        $berhasil = $this->dosenModel->delete((int) $id);

        if (!$berhasil) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen gagal dihapus'
                ]);
        }

        return $this->response->setJSON([
            'status'   => true,
            'message'  => 'Data dosen berhasil dihapus',
            'id_dosen' => (int) $id
        ]);

    } catch (\Throwable $e) {
        log_message('error', 'DELETE dosen: ' . $e->getMessage());

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menghapus data'
            ]);
    }
}
}
