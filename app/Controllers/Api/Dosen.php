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

    // GET: Menampilkan ID dan nama dosen
    public function index()
    {
        $data = $this->dosenModel
            ->select(['id_dosen', 'nama'])
            ->findAll();

        return $this->response->setJSON([
            'status'      => true,
            'message'     => 'Data dosen berhasil diambil',
            'jumlah_data' => count($data),
            'data'        => $data
        ]);
    }

    // GET: Menampilkan detail dosen berdasarkan ID
    public function show($id)
    {
        $data = $this->dosenModel
            ->select(['id_dosen', 'nama'])
            ->find($id);

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
    }

    // GET: Mencari dosen berdasarkan nama
    public function search()
    {
        $nama = $this->request->getGet('nama');

        if (empty($nama)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Parameter nama wajib diisi'
                ]);
        }

        $data = $this->dosenModel
            ->select(['id_dosen', 'nama'])
            ->like('nama', $nama)
            ->findAll();

        return $this->response->setJSON([
            'status'      => true,
            'message'     => 'Pencarian dosen berhasil',
            'jumlah_data' => count($data),
            'data'        => $data
        ]);
    }

    // POST: Menambahkan data dosen
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (
            !is_array($data) ||
            empty($data['id_dosen']) ||
            empty($data['nip']) ||
            empty($data['nama'])
        ) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'ID dosen, NIP, dan nama wajib diisi'
                ]);
        }

        // Periksa apakah ID sudah digunakan
        if ($this->dosenModel->find($data['id_dosen'])) {
            return $this->response
                ->setStatusCode(409)
                ->setJSON([
                    'status'  => false,
                    'message' => 'ID dosen sudah digunakan'
                ]);
        }

        try {
            // Proses penyimpanan data dosen
            $hasil = $this->dosenModel->insert($data);

            if ($hasil === false) {
                $dbError = $this->dosenModel->db->error();

                $lastQuery = (string)
                    $this->dosenModel->db->getLastQuery();

                log_message(
                    'error',
                    'Gagal insert dosen. DB ERROR: ' .
                    json_encode($dbError)
                );

                log_message(
                    'error',
                    'LAST QUERY: ' . $lastQuery
                );

                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                        'status'     => false,
                        'message'    => 'Data dosen gagal disimpan',
                        'errors'     => $this->dosenModel->errors(),
                        'db_error'   => $dbError,
                        'last_query' => $lastQuery
                    ]);
            }

            // Ambil kembali data yang sudah disimpan
            $dosenBaru = $this->dosenModel->find(
                $data['id_dosen']
            );

            if (!$dosenBaru) {
                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                        'status'  => false,
                        'message' => 'Insert berhasil dipanggil, tetapi data tidak ditemukan'
                    ]);
            }

            return $this->response
                ->setStatusCode(201)
                ->setJSON([
                    'status'  => true,
                    'message' => 'Data dosen berhasil ditambahkan',
                    'data'    => $dosenBaru
                ]);

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Gagal menambahkan data dosen: ' .
                $e->getMessage()
            );

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'      => false,
                    'message'     => 'Data dosen gagal ditambahkan',
                    'debug_error' => $e->getMessage()
                ]);
        }
    }

    // PUT: Mengubah data dosen berdasarkan ID
    public function update($id)
    {
        $dosen = $this->dosenModel->find($id);

        if (!$dosen) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen tidak ditemukan'
                ]);
        }

        $data = $this->request->getJSON(true);

        if (!is_array($data) || empty($data)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data perubahan tidak boleh kosong'
                ]);
        }

        // ID dosen tidak boleh diubah
        unset($data['id_dosen']);

        try {
            $this->dosenModel->update($id, $data);

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Data dosen berhasil diperbarui',
                'data'    => $this->dosenModel->find($id)
            ]);

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Gagal memperbarui data dosen: ' .
                $e->getMessage()
            );

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen gagal diperbarui'
                ]);
        }
    }

    // DELETE: Menghapus data dosen berdasarkan ID
    public function delete($id)
    {
        $dosen = $this->dosenModel->find($id);

        if (!$dosen) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen tidak ditemukan'
                ]);
        }

        try {
            $this->dosenModel->delete($id);

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Data dosen berhasil dihapus',
                'data'    => [
                    'id_dosen' => $id
                ]
            ]);

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Gagal menghapus data dosen: ' .
                $e->getMessage()
            );

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data dosen gagal dihapus'
                ]);
        }
    }

    // GET: Memfilter dosen berdasarkan jabatan dan status aktivitas
    public function filter()
    {
        $status = $this->request->getGet('status');
        $jabatan = $this->request->getGet('jabatan');

        if (empty($status)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Parameter status wajib diisi'
                ]);
        }

        $builder = $this->dosenModel
            ->select(['id_dosen', 'nama'])
            ->where('status_aktivitas', $status);

        // Filter jabatan jika parameter dikirim
        if (!empty($jabatan)) {
            $builder->where(
                'jabatan_fungsional',
                $jabatan
            );
        }

        $data = $builder->findAll();

        return $this->response->setJSON([
            'status'      => true,
            'message'     => 'Filter dosen berhasil',
            'jumlah_data' => count($data),
            'data'        => $data
        ]);
    }
}
