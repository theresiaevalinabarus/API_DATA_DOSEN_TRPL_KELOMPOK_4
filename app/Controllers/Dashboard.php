<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DosenModel;

class Dashboard extends BaseController
{
    protected $dosenModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
    }

    // Menampilkan halaman Dashboard
    public function index()
    {
        // Mengambil data dosen dari database
        $dosen = $this->dosenModel
            ->orderBy('id_dosen', 'ASC')
            ->findAll();

        // Menghitung jumlah seluruh dosen
        $totalDosen = count($dosen);

        // Menghitung jumlah dosen aktif dan tidak aktif
        $totalAktif = 0;
        $totalTidakAktif = 0;

        foreach ($dosen as $item) {

            $status = strtolower(
                trim($item['status_aktivitas'] ?? '')
            );

            if ($status === 'aktif') {
                $totalAktif++;
            } elseif ($status === 'tidak aktif') {
                $totalTidakAktif++;
            }
        }

        // Data yang dikirim ke halaman Dashboard
        $data = [
            'title'            => 'Dashboard Data Dosen',
            'heading'          => 'Dashboard',
            'subtitle'         => 'Sistem Informasi Data Dosen TRPL',
            'active'           => 'dashboard',

            // Data dosen
            'dosen'            => $dosen,

            // Statistik dosen
            'totalDosen'       => $totalDosen,
            'totalAktif'       => $totalAktif,
            'totalTidakAktif'  => $totalTidakAktif
        ];

        return view('Dashboard', $data);
    }
}
